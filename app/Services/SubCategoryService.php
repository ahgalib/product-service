<?php

namespace App\Services;

use App\Repositories\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryService
{
    protected $subCategoryRepo;

    public function __construct(SubCategoryRepository $subCategoryRepo)
    {
        $this->subCategoryRepo = $subCategoryRepo;
    }

    public function getAll(Request $request)
    {
        return $this->subCategoryRepo->getPaginatedSubCategories($request);
    }

    public function create($requestData)
    {
        return $this->subCategoryRepo->createSubCategory($requestData);
    }

    public function update($id, $requestData)
    {
        $subCategory = $this->subCategoryRepo->find($id);
        if (!$subCategory) {
            throw new \Exception('SubCategory not found');
        }
        $subCategory->update($requestData);
        return $subCategory;
    }

    public function delete($id)
    {
        $subCategory = $this->subCategoryRepo->find($id);
        if (!$subCategory) {
            throw new \Exception('SubCategory not found');
        }
        $subCategory->delete();
        return $subCategory;
    }

    public function find($id)
    {
        return $this->subCategoryRepo->find($id);
    }
}
