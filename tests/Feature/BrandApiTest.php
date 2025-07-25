<?php

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Brand API', function () {
    it('can list brands', function () {
        Brand::factory()->count(3)->create();
        $response = $this->getJson('/api/brands');
        $response->assertOk()->assertJsonStructure(['data']);
    });

    it('can create a brand', function () {
        $data = Brand::factory()->make()->toArray();
        $response = $this->postJson('/api/brands', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('brands', ['name' => $data['name']]);
    });

    it('can show a brand', function () {
        $brand = Brand::factory()->create();
        $response = $this->getJson("/api/brands/{$brand->id}");
        $response->assertOk()->assertJsonFragment(['id' => $brand->id]);
    });

    it('can update a brand', function () {
        $brand = Brand::factory()->create();
        $update = ['name' => 'Updated Brand'];
        $response = $this->putJson("/api/brands/{$brand->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'name' => 'Updated Brand']);
    });

    it('can delete a brand', function () {
        $brand = Brand::factory()->create();
        $response = $this->deleteJson("/api/brands/{$brand->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    });
});
