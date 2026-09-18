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

        // Array Gambar Spesifik Per Kategori (Unsplash Direct URL)
        $categoryImages = [
            'Electronics' => [
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
                'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600&q=80',
                'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=600&q=80',
                'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&q=80',
            ],
            'Fashion' => [
                'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&q=80',
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80',
                'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=600&q=80',
            ],
            'Home & Garden' => [
                'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=600&q=80',
                'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=600&q=80',
                'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=600&q=80',
            ],
            'Sports & Outdoors' => [
                'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=600&q=80',
                'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=600&q=80',
                'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=600&q=80',
            ],
            'Books & Media' => [
                'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&q=80',
                'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80',
                'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80',
            ]
        ];

        // 1. Data 5 Kategori (Masing-masing 10 Produk = Total 50 Produk)
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

        // 2. Loop Setiap Kategori dan Insert Produk
        foreach ($data as $categoryName => $products) {
            
            $category = ProductCategory::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            $images = $categoryImages[$categoryName] ?? ['https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80'];

            foreach ($products as $productName) {
                DB::table('products')->insert([
                    'name' => $productName,
                    'slug' => Str::slug($productName . '-' . $faker->unique()->numerify('###')),
                    'description' => $faker->paragraph(3),
                    'image' => $faker->randomElement($images),
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