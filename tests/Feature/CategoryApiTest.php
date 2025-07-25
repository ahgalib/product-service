<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Category API', function () {
    it('can list categories', function () {
        Category::factory()->count(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertOk()->assertJsonStructure(['data']);
    });

    it('can create a category', function () {
        $data = Category::factory()->make()->toArray();
        $response = $this->postJson('/api/categories', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('categories', ['name' => $data['name']]);
    });

    it('can show a category', function () {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/categories/{$category->id}");
        $response->assertOk()->assertJsonFragment(['id' => $category->id]);
    });

    it('can update a category', function () {
        $category = Category::factory()->create();
        $update = ['name' => 'Updated Category'];
        $response = $this->putJson("/api/categories/{$category->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Category']);
    });

    it('can delete a category', function () {
        $category = Category::factory()->create();
        $response = $this->deleteJson("/api/categories/{$category->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    });
});
