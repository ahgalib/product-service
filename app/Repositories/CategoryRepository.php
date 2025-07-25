<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getPaginatedCategories($request)
    {
        return Category::paginate(10);
    }

    public function createCategory($data)
    {
        return Category::create($data);
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = $this->find($id);
        if ($category) {
            $category->delete();
        }
        return $category;
    }
}
