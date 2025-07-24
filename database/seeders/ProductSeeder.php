<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data produk yang ada untuk menghindari duplikasi
        Product::truncate();

        $products = [
            ['name' => 'Sunstar Fresh Melon Juice', 'price' => 20000, 'stock' => 50, 'description' => 'Jus melon segar dan menyehatkan.'],
            ['name' => 'Sunstar Fresh Banana Juice', 'price' => 40000, 'stock' => 30, 'description' => 'Jus pisang kaya akan nutrisi.'],
            ['name' => 'Fresh Cucumber', 'price' => 10000, 'stock' => 100, 'description' => 'Timun segar langsung dari kebun.'],
            ['name' => 'Fresh Milk Carton', 'price' => 60000, 'stock' => 40, 'description' => 'Susu murni dalam kemasan karton.'],
            ['name' => 'Fresh Banana', 'price' => 20000, 'stock' => 80, 'description' => 'Pisang segar pilihan.'],
            ['name' => 'Orange Juice', 'price' => 40000, 'stock' => 60, 'description' => 'Jus jeruk asli tanpa pemanis buatan.'],
            ['name' => 'Fresh Bread', 'price' => 15000, 'stock' => 70, 'description' => 'Roti tawar lembut untuk sarapan.'],
            ['name' => 'Chocolate Bar', 'price' => 25000, 'stock' => 90, 'description' => 'Cokelat batangan premium.'],
            ['name' => 'Potato Chips', 'price' => 18000, 'stock' => 120, 'description' => 'Keripik kentang renyah dan gurih.'],
            ['name' => 'Mineral Water', 'price' => 5000, 'stock' => 200, 'description' => 'Air mineral dari sumber pegunungan.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
