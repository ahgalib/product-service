<?php

use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Product Variant API', function () {
    it('can list product variants', function () {
        ProductVariant::factory()->count(3)->create();
        $response = $this->getJson('/api/product-variants');
        $response->assertOk()->assertJsonStructure(['data']);
    });

    it('can create a product variant', function () {
        $data = ProductVariant::factory()->make()->toArray();
        $response = $this->postJson('/api/product-variants', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('product_variants', ['sku' => $data['sku']]);
    });

    it('can show a product variant', function () {
        $variant = ProductVariant::factory()->create();
        $response = $this->getJson("/api/product-variants/{$variant->id}");
        $response->assertOk()->assertJsonFragment(['id' => $variant->id]);
    });

    it('can update a product variant', function () {
        $variant = ProductVariant::factory()->create();
        $update = ['sku' => 'SKU-UPDATED'];
        $response = $this->putJson("/api/product-variants/{$variant->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('product_variants', ['id' => $variant->id, 'sku' => 'SKU-UPDATED']);
    });

    it('can delete a product variant', function () {
        $variant = ProductVariant::factory()->create();
        $response = $this->deleteJson("/api/product-variants/{$variant->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('product_variants', ['id' => $variant->id]);
    });

    it('can adjust stock for a product variant', function () {
        $variant = ProductVariant::factory()->create(['stock' => 10]);
        $response = $this->postJson("/api/product-variants/{$variant->id}/adjust-stock", ['quantity' => 5]);
        $response->assertOk();
        $this->assertDatabaseHas('product_variants', ['id' => $variant->id, 'stock' => 15]);
    });
});
