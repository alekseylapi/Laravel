<?php
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">+ New Category</a>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->deleted_at ? 'Deleted' : 'Active' }}</td>
                    <td>
                        @if($category->deleted_at)
                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-warning">Restore</button>
                            </form>
                        @else
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
