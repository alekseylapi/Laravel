<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryDetailResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\SuccessResource;
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
        return new CategoryDetailResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $categoryData = $request->all();
        $category = new Category();
        $category->name = $categoryData["name"];
        $category->save();
        return new CategoryDetailResource($category);
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $categoryData = $request->all();
        $category->name = $categoryData['name'];
        $category->save();
        return new CategoryDetailResource($category);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return new SuccessResource([]);
    }

    public function restore(Category $category)
    {
        $category->restore();

        return new CategoryDetailResource($category);
    }
}
