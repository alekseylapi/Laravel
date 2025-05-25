<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryDetailResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use App\Services\Category\UpdateAction;

class CategoryController
{
    public function index()
    {
        $categories = Category::withTrashed()->get();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryDetailResource($category);
    }

    public function store(StoreCategoryRequest $request, UpdateAction $action)
    {
        $action = app(UpdateAction::class); // @todo сделано для примера, удалить
        $category = $action->update(new Category(), $request->all());

        return new CategoryDetailResource($category);
    }

    public function update(Category $category, UpdateCategoryRequest $request, UpdateAction $action)
    {
        $category = $action->update($category, $request->all());

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
