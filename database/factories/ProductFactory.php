<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $subcategory = Subcategory::where('category_id', $category->id)->inRandomOrder()->first();
        $brand = Brand::inRandomOrder()->first();

        // Realistic product types by category
        $productTypes = [
            'Electronics' => ['Smartphone', 'Laptop', 'Headphones', 'Smartwatch', 'Tablet'],
            'Fashion' => ['Jeans', 'T-Shirt', 'Sneakers', 'Jacket', 'Dress'],
            'Home & Kitchen' => ['Blender', 'Microwave Oven', 'Sofa', 'Coffee Maker', 'Cookware Set'],
            'Beauty & Personal Care' => ['Face Cream', 'Shampoo', 'Perfume', 'Body Lotion', 'Lipstick'],
            'Sports & Outdoors' => ['Running Shoes', 'Tennis Racket', 'Backpack', 'Yoga Mat', 'Dumbbells'],
            'Books' => ['Mystery Novel', 'Self-Help Book', 'Science Textbook', 'Children’s Story Book'],
            'Automotive' => ['Car Stereo', 'Air Filter', 'Dash Cam', 'LED Headlights', 'Bike Helmet'],
            'Groceries' => ['Olive Oil', 'Green Tea', 'Almonds', 'Protein Bar', 'Organic Honey'],
            'Health & Wellness' => ['Vitamins', 'Whey Protein', 'Massage Gun', 'Blood Pressure Monitor'],
            'Toys & Games' => ['Remote Control Car', 'Board Game', 'Puzzle Set', 'Building Blocks'],
        ];

        $models = [
            'Pro',
            'Max',
            'Ultra',
            'Plus',
            'Series 7',
            'Deluxe Edition',
            'Limited Edition',
            'Compact',
            'Smart',
            '4K',
            '5G',
            'Wireless',
            'Eco',
            'Edition X',
            'S22',
            'V2'
        ];

        $typeOptions = $productTypes[$category->name] ?? ['Gadget'];
        $type = $this->faker->randomElement($typeOptions);
        $model = $this->faker->randomElement($models);
        $productName = "{$brand->name} $type $model";

        return [
            'name' => $productName,
            'slug' => Str::slug($productName) . '-' . Str::random(5),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 2000),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'stock_quantity' => $this->faker->numberBetween(1, 300),
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'sub_category_id' => $subcategory->id,
            'is_active' => $this->faker->boolean(90),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
