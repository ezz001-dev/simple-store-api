<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mengambil dan mengembalikan data statistik untuk dasbor admin.
     */
    public function stats()
    {
        // 1. Data untuk Kartu Ringkasan
        $summary = [
            'total_revenue' => Order::sum('total_amount'),
            'total_stock' => Product::sum('stock'),
            'items_sold' => OrderDetail::sum('quantity'),
            // Untuk kategori, kita hitung jumlah produk unik sebagai asumsi
            'category_count' => Product::count(),
            'daily_revenue' => Order::whereDate('created_at', Carbon::today())->sum('total_amount'),
            'daily_transactions' => Order::whereDate('created_at', Carbon::today())->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        // 2. Data Penjualan 6 Bulan Terakhir
        $monthly_sales = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw("SUM(total_amount) as total")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'))
            ->get();

        // 3. Data Produk Terlaris (Top 3)
        $best_sellers = OrderDetail::select(
            'products.name',
            DB::raw('SUM(order_details.quantity) as quantity')
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderByDesc('quantity')
            ->limit(3)
            ->get();

        // 4. Data Stok Terendah (Top 5)
        $stock_levels = Product::select('name', 'stock')
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return response()->json([
            'summary' => $summary,
            'monthly_sales' => $monthly_sales,
            'best_sellers' => $best_sellers,
            'stock_levels' => $stock_levels,
        ]);
    }
}
