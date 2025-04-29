<?php

namespace App\Http\Controllers\Admin;

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
}
