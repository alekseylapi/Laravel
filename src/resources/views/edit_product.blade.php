<?php
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Product</h1>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required minlength="10">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01" min="1" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
