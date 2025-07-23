<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class OrderController extends Controller
{
    /**
     * Memproses checkout dari keranjang belanja customer.
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:cash' // Untuk saat ini hanya 'cash'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $items = $request->items;
        $user = Auth::user();

        try {
            $order = DB::transaction(function () use ($items, $user, $request) {
                // 1. Buat order baru
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0, // Akan diupdate nanti
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                $totalAmount = 0;

                foreach ($items as $item) {
                    // Kunci produk untuk mencegah race condition saat update stok
                    $product = Product::lockForUpdate()->find($item['product_id']);

                    // 2. Cek ketersediaan stok
                    if ($product->stock < $item['quantity']) {
                        throw new Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
                    }

                    // 3. Buat detail order
                    $order->details()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price, // Simpan harga saat ini
                    ]);

                    // 4. Kurangi stok produk
                    $product->decrement('stock', $item['quantity']);

                    $totalAmount += $product->price * $item['quantity'];
                }

                // 5. Update total harga pada order
                $order->update(['total_amount' => $totalAmount]);

                return $order;
            });

            // Muat relasi untuk response
            $order->load('details.product');

            return response()->json([
                'message' => 'Checkout berhasil, pesanan sedang diproses.',
                'order' => $order,
            ], 201);
        } catch (Exception $e) {
            // Jika terjadi error (misal: stok tidak cukup), transaksi akan di-rollback
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Menampilkan laporan penjualan untuk Admin.
     */
    public function salesReport()
    {
        $orders = Order::with(['user:id,name,email', 'details.product:id,name'])
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }
}
