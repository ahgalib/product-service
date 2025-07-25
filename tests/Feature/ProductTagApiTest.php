<?php

use App\Models\ProductTag;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Product Tag API', function () {
    it('can list product tags by product', function () {
        $product = Product::factory()->create();
        ProductTag::factory()->count(2)->create(['product_id' => $product->id]);
        $response = $this->getJson('/api/product-tags?product_id=' . $product->id);
        $response->assertOk()->assertJsonFragment(['product_id' => $product->id]);
    });

    it('can create a product tag', function () {
        $product = Product::factory()->create();
        $data = ProductTag::factory()->make(['product_id' => $product->id])->toArray();
        $response = $this->postJson('/api/product-tags', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('product_tags', ['product_id' => $product->id, 'name' => $data['name']]);
    });

    it('can show a product tag', function () {
        $tag = ProductTag::factory()->create();
        $response = $this->getJson("/api/product-tags/{$tag->id}");
        $response->assertOk()->assertJsonFragment(['id' => $tag->id]);
    });

    it('can update a product tag', function () {
        $tag = ProductTag::factory()->create();
        $update = ['name' => 'Updated Tag'];
        $response = $this->putJson("/api/product-tags/{$tag->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('product_tags', ['id' => $tag->id, 'name' => 'Updated Tag']);
    });

    it('can delete a product tag', function () {
        $tag = ProductTag::factory()->create();
        $response = $this->deleteJson("/api/product-tags/{$tag->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('product_tags', ['id' => $tag->id]);
    });
});
