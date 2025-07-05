<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Televisions', 'Headphones', 'Gaming Consoles'],
            'Fashion' => ['Men\'s Clothing', 'Women\'s Clothing', 'Footwear', 'Accessories', 'Jewelry'],
            'Home & Kitchen' => ['Furniture', 'Kitchen Appliances', 'Bedding', 'Cookware', 'Lighting'],
            'Beauty & Personal Care' => ['Skincare', 'Haircare', 'Makeup', 'Fragrances', 'Oral Care'],
            'Sports & Outdoors' => ['Exercise Equipment', 'Camping & Hiking', 'Cycling', 'Sports Footwear', 'Outdoor Gear'],
            'Automotive' => ['Car Electronics', 'Tires', 'Motorcycle Accessories', 'Car Care', 'Interior Accessories'],
            'Books' => ['Fiction', 'Non-fiction', 'Children\'s Books', 'Textbooks', 'Comics'],
            'Toys & Games' => ['Educational Toys', 'Board Games', 'Action Figures', 'Puzzles', 'Remote Control Toys'],
            'Health & Wellness' => ['Supplements', 'Medical Equipment', 'Fitness Trackers', 'Massagers', 'Vitamins'],
            'Groceries' => ['Beverages', 'Snacks', 'Organic Food', 'Cleaning Supplies', 'Packaged Foods'],
        ];

        foreach ($categories as $catName => $subcats) {
            $category = Category::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
            ]);

            foreach ($subcats as $subcatName) {
                SubCategory::create([
                    'name' => $subcatName,
                    'slug' => Str::slug($subcatName),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
