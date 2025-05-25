@extends('layouts.app')

@section('title', 'Create Category')
@section('content')
    <div class="container">
        <h1>Create Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success mb-3">Categories list</a>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
