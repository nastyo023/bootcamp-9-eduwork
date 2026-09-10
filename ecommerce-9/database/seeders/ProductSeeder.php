<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Data Kategori & Produk
        $data = [
            'Electronics' => [
                'Wireless Bluetooth Headphones', 'USB-C Cable 2m', '4K Webcam HD', 'Portable Power Bank',
                'Mechanical Gaming Keyboard', 'Wireless Mouse Pro', 'LED Desk Lamp', 'Phone Stand',
                'USB Hub 7 Port', 'HDMI Cable 2m'
            ],
            'Fashion' => [
                'Cotton T-Shirt', 'Denim Jeans', 'Leather Jacket', 'Casual Sneakers',
                'Winter Hoodie', 'Cargo Pants', 'Polo Shirt', 'Athletic Sports Shorts',
                'Casual Blazer', 'Crew Neck Sweater'
            ],
            'Home & Garden' => [
                'Indoor Plant Pot', 'Desk Organizer Set', 'Table Lamp', 'Wall Mirror',
                'Throw Pillow Cover', 'Door Mat', 'Shelf Organizer', 'Kitchen Knife Set',
                'Bed Sheets Set', 'Wall Clock'
            ],
            'Sports & Outdoors' => [
                'Yoga Mat', 'Dumbbells Set', 'Resistance Bands', 'Running Shoes',
                'Gym Bag', 'Water Bottle 1L', 'Exercise Ball', 'Jump Rope',
                'Camping Tent', 'Bicycle Helmet'
            ],
            'Books & Media' => [
                'Programming Guide Book', 'Self-Help Novel', 'Science Fiction', 'Business Strategy',
                'Cooking Recipes Book', 'Art & Design Book', 'Biography', 'Travel Guide',
                'Learning Python Book', 'Marketing Handbook'
            ]
        ];

        // 2. Loop Setiap Kategori dan Insert Produknya
        foreach ($data as $categoryName => $products) {
            
            // Buat kategori jika belum ada di database
            $category = ProductCategory::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            foreach ($products as $productName) {
                DB::table('products')->insert([
                    'name' => $productName,
                    'slug' => Str::slug($productName . '-' . $faker->unique()->numerify('###')),
                    'description' => $faker->paragraph(3),
                    'image' => 'images/products/example.jpg',
                    'stock' => $faker->numberBetween(5, 100),
                    'price' => $faker->numberBetween(50000, 5000000),
                    'product_category_id' => $category->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}