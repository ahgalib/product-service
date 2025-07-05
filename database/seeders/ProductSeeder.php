<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Black', 'White', 'Green', 'Gray'];
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $tags = ['Bluetooth', 'Wireless', 'Eco-friendly', 'Portable', '4K', 'HD', 'Organic', 'Waterproof'];

        $chunkSize = 1000; // Reduced from 5000 for better memory management
        $total = 100000; // Reduced from 500000 for testing purposes

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $products = Product::factory()
                ->count($chunkSize)
                ->create();

            foreach ($products as $product) {
                // Add random images
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => 'https://via.placeholder.com/600x600.png?text=' . urlencode($product->name),
                    'is_primary' => true,
                ]);

                // Add 2-4 variants
                $usedVariants = [];
                foreach (range(1, rand(2, 4)) as $j) {
                    $color = $colors[array_rand($colors)];
                    $size = $sizes[array_rand($sizes)];
                    $key = $color . '-' . $size;

                    if (isset($usedVariants[$key])) continue;

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(Str::slug($product->slug . '-' . $key)),
                        'size' => $size,
                        'color' => $color,
                        'price' => $product->price + rand(0, 50),
                        'stock' => rand(1, 100),
                    ]);

                    $usedVariants[$key] = true;
                }

                // Add 2-3 random tags
                $selectedTags = array_rand($tags, rand(2, 3));
                // Handle case when array_rand returns single key (not array)
                $selectedTags = is_array($selectedTags) ? $selectedTags : [$selectedTags];

                foreach ($selectedTags as $index) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'tag' => $tags[$index],
                    ]);
                }
            }
        }
    }
}
