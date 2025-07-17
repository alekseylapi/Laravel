@extends('layouts.admin')

@section('title', 'Главная - Админ-панель')
@section('page-title', 'Главная')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ \App\Models\Category::count() }}</h4>
                        <p class="mb-0">Категории</p>
                    </div>
                    <i class="fas fa-tags fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ \App\Models\Product::count() }}</h4>
                        <p class="mb-0">Продукты</p>
                    </div>
                    <i class="fas fa-box fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ \App\Models\User::count() }}</h4>
                        <p class="mb-0">Пользователи</p>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ \App\Models\Product::where('deleted_at', '!=', null)->count() }}</h4>
                        <p class="mb-0">Удаленные</p>
                    </div>
                    <i class="fas fa-trash fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Последние действия
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-plus text-success me-2"></i>
                            <strong>Добро пожаловать!</strong>
                            <p class="mb-0 text-muted">Вы успешно вошли в систему</p>
                        </div>
                        <small class="text-muted">{{ now()->format('d.m.Y H:i') }}</small>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-cogs text-primary me-2"></i>
                            <strong>Система готова к работе</strong>
                            <p class="mb-0 text-muted">Все модули функционируют нормально</p>
                        </div>
                        <small class="text-muted">{{ now()->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Быстрые действия
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Добавить категорию
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-2"></i>Добавить продукт
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-list me-2"></i>Управление категориями
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning">
                        <i class="fas fa-list me-2"></i>Управление продуктами
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 