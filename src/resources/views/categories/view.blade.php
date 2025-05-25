<?php /** @var \App\Models\Category $category */ ?>

@extends('layouts.app')

@section('title', 'View Category ' . $category->id)
@section('content')
    <div class="container">
        <h1>View Category {{ $category->id }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success mb-3">Categories list</a>
        <div class="form-group">
            <label>Name</label>
            <span>{{ $category->name }}</span>
        </div>
    </div>
@endsection
