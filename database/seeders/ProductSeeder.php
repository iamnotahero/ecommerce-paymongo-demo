<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation.',
                'price' => 2999.00,
                'image' => 'headphones.jpg',
            ],
            [
                'name' => 'Gaming Mouse',
                'description' => 'Ergonomic gaming mouse with customizable RGB lighting.',
                'price' => 1499.00,
                'image' => 'gaming_mouse.jpg',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Durable mechanical keyboard with tactile switches.',
                'price' => 3999.00,
                'image' => 'keyboard.jpg',
            ],
            [
                'name' => 'Smartwatch',
                'description' => 'Track your health and notifications on the go.',
                'price' => 4999.00,
                'image' => 'smartwatch.jpg',
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable Bluetooth speaker with deep bass and long battery life.',
                'price' => 1999.00,
                'image' => 'speaker.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
