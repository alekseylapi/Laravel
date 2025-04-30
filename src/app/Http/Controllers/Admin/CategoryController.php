<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        /** @var Category[] $category */
        $category = Category::all();
        return CategoryResource::collection($category);
    }
    public function view(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $categoryData = $request->all();

        $category = new Category();
        $category->id = $categoryData['id'];
        $category->category_name = $categoryData['category_name'];
        $category->save();

        return new CategoryResource($category);
    }

    public function update(string $category_id)
    {
        return "Category update {$category_id}";
    }

    public function delete(string $category_id)
    {
        return "Category delete {$category_id}";
    }
}
