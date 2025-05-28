@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Category: {{ $category->name }}</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name"
                       class="form-control"
                       value="{{ old('name', $category->name) }}"
                       required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Category</button>
        </form>
    </div>
@endsection
