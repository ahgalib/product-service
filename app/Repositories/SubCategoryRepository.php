<?php

namespace App\Repositories;

use App\Models\SubCategory;

class SubCategoryRepository
{
    public function getPaginatedSubCategories($request)
    {
        return SubCategory::paginate(10);
    }

    public function createSubCategory($data)
    {
        return SubCategory::create($data);
    }

    public function find($id)
    {
        return SubCategory::find($id);
    }

    public function updateSubCategory($id, $data)
    {
        $subCategory = $this->find($id);
        if ($subCategory) {
            $subCategory->update($data);
        }
        return $subCategory;
    }

    public function deleteSubCategory($id)
    {
        $subCategory = $this->find($id);
        if ($subCategory) {
            $subCategory->delete();
        }
        return $subCategory;
    }
}
