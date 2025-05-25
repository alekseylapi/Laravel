<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Resources\SuccessResource;
use App\Services\Category\UpdateAction;

class CategoryController
{
    public function index()
    {
        $categories = Category::withTrashed()->get();

        return view(
            'categories.index',
            [
                'categories' => $categories,
            ]
        );
    }

    public function show(Category $category)
    {
        return view('categories.view', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request, UpdateAction $action)
    {
        $category = $action->update(new Category(), $request->all());

//        return redirect(route('admin.categories.index'));
        return redirect(route('admin.categories.show', $category->id));
    }

    public function update(Category $category, UpdateCategoryRequest $request, UpdateAction $action)
    {
        $category = $action->update($category, $request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return new SuccessResource([]);
    }

    public function restore(int $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return new CategoryResource($category);
    }
}
