<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Product API', function () {
    it('can list products', function () {
        Product::factory()->count(3)->create();
        $response = $this->getJson('/api/products');
        $response->assertOk()->assertJsonStructure(['data']);
    });

    it('can create a product', function () {
        $data = Product::factory()->make()->toArray();
        $response = $this->postJson('/api/products', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    });

    it('can update a product', function () {
        $product = Product::factory()->create();
        $update = ['name' => 'Updated Name'];
        $response = $this->putJson("/api/products/{$product->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Name']);
    });

    it('can delete a product', function () {
        $product = Product::factory()->create();
        $response = $this->deleteJson("/api/products/{$product->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    });

    it('can search products', function () {
        Product::factory()->create(['name' => 'UniqueProductName']);
        $response = $this->getJson('/api/products/search?query=UniqueProductName');
        $response->assertOk()->assertJsonFragment(['name' => 'UniqueProductName']);
    });

    it('can autocomplete products', function () {
        Product::factory()->create(['name' => 'AutoProduct']);
        $response = $this->getJson('/api/products/autocomplete?query=Auto');
        $response->assertOk()->assertJsonFragment(['name' => 'AutoProduct']);
    });
});
