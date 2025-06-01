<?php

namespace App\Http\Controllers\Admin;

use App\Events\CategoryCreated;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Resources\SuccessResource;
use App\Services\Category\UpdateAction;
use Illuminate\Http\RedirectResponse;

class CategoryController
{
    public function index()
    {
        $categories = Category::withTrashed()
            ->orderBy('created_at')
            ->get();

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
        CategoryCreated::dispatch($category);
        return redirect(route('admin.categories.show', $category->id));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Category $category, UpdateCategoryRequest $request, UpdateAction $action): RedirectResponse
    {
        $action->update($category, $request->all());

        return redirect()
            ->route('admin.categories.show', $category->id)
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }

    public function restore(int $id): RedirectResponse
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category restored successfully');
    }
}
