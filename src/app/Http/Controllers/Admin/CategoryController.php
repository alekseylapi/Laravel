<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Resources\SuccessResource;

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
        $category->category_name = $categoryData["category_name"];
        $category->save();
        return new CategoryResource($category);
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $categoryData = $request->all();
        $category->category_name = $categoryData['category_name'];
        $category->save();
        return new CategoryResource($category);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return new SuccessResource([]);
    }

    public function restore(int $id)
    {
        $category = Category::withTrashed()->findOrFail($id); // <--- обязательно withTrashed()
        $category->restore();

        return new CategoryResource($category);
    }
}
