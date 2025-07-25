<?php

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Product Image API', function () {
    it('can list product images by product', function () {
        $product = Product::factory()->create();
        ProductImage::factory()->count(2)->create(['product_id' => $product->id]);
        $response = $this->getJson('/api/product-images?product_id=' . $product->id);
        $response->assertOk()->assertJsonFragment(['product_id' => $product->id]);
    });

    it('can create a product image', function () {
        $product = Product::factory()->create();
        $data = ProductImage::factory()->make(['product_id' => $product->id])->toArray();
        $response = $this->postJson('/api/product-images', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('product_images', ['product_id' => $product->id, 'url' => $data['url']]);
    });

    it('can show a product image', function () {
        $image = ProductImage::factory()->create();
        $response = $this->getJson("/api/product-images/{$image->id}");
        $response->assertOk()->assertJsonFragment(['id' => $image->id]);
    });

    it('can update a product image', function () {
        $image = ProductImage::factory()->create();
        $update = ['url' => 'https://example.com/updated.jpg'];
        $response = $this->putJson("/api/product-images/{$image->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('product_images', ['id' => $image->id, 'url' => 'https://example.com/updated.jpg']);
    });

    it('can delete a product image', function () {
        $image = ProductImage::factory()->create();
        $response = $this->deleteJson("/api/product-images/{$image->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('product_images', ['id' => $image->id]);
    });
});
