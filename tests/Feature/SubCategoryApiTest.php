<?php

use App\Models\SubCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('SubCategory API', function () {
    it('can list subcategories', function () {
        SubCategory::factory()->count(3)->create();
        $response = $this->getJson('/api/subcategories');
        $response->assertOk()->assertJsonStructure(['data']);
    });

    it('can create a subcategory', function () {
        $data = SubCategory::factory()->make()->toArray();
        $response = $this->postJson('/api/subcategories', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('sub_categories', ['name' => $data['name']]);
    });

    it('can show a subcategory', function () {
        $subCategory = SubCategory::factory()->create();
        $response = $this->getJson("/api/subcategories/{$subCategory->id}");
        $response->assertOk()->assertJsonFragment(['id' => $subCategory->id]);
    });

    it('can update a subcategory', function () {
        $subCategory = SubCategory::factory()->create();
        $update = ['name' => 'Updated SubCategory'];
        $response = $this->putJson("/api/subcategories/{$subCategory->id}", $update);
        $response->assertOk();
        $this->assertDatabaseHas('sub_categories', ['id' => $subCategory->id, 'name' => 'Updated SubCategory']);
    });

    it('can delete a subcategory', function () {
        $subCategory = SubCategory::factory()->create();
        $response = $this->deleteJson("/api/subcategories/{$subCategory->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('sub_categories', ['id' => $subCategory->id]);
    });
});
