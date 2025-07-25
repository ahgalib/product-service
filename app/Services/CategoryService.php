<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getAll(Request $request)
    {
        return $this->categoryRepo->getPaginatedCategories($request);
    }

    public function create($requestData)
    {
        return $this->categoryRepo->createCategory($requestData);
    }

    public function update($id, $requestData)
    {
        $category = $this->categoryRepo->find($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }
        $category->update($requestData);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->categoryRepo->find($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }
        $category->delete();
        return $category;
    }

    public function find($id)
    {
        return $this->categoryRepo->find($id);
    }
}
