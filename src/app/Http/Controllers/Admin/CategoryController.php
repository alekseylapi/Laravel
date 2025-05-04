<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $categoryData = $request->all();
        $category = new Category();
        $category -> category_name = $categoryData["category_name"];
        $category -> save();
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
