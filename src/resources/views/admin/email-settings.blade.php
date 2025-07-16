@extends('layouts.admin')

@section('title', 'Настройки Email - Админ-панель')
@section('page-title', 'Настройки Email')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-envelope me-2"></i>Настройки уведомлений
            </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email администратора</label>
                            <input type="email" class="form-control" value="{{ config('mail.admin_email', 'admin@example.com') }}" readonly>
                            <small class="text-muted">Настройте в файле .env как ADMIN_EMAIL</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email отправителя</label>
                            <input type="email" class="form-control" value="{{ config('mail.from.address') }}" readonly>
                            <small class="text-muted">Настройте в файле .env как MAIL_FROM_ADDRESS</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Статус очередей Redis</label>
                    <div id="queue-status">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            <span>Загрузка статуса...</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Информация:</strong> При создании товара автоматически отправляется уведомление на email администратора через Redis очереди.
                </div>
            </div>
        </div>

        <!-- Статистика очередей -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Статистика очередей Redis
                </h5>
            </div>
            <div class="card-body">
                <div class="row" id="queue-stats">
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-primary" id="emails-queue">-</h4>
                            <small class="text-muted">Email очередь</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-success" id="bulk-emails-queue">-</h4>
                            <small class="text-muted">Массовые email</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-info" id="default-queue">-</h4>
                            <small class="text-muted">Общая очередь</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Действия
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" onclick="testEmail()">
                        <i class="fas fa-paper-plane me-2"></i>Тест уведомления
                    </button>
                    
                    <button type="button" class="btn btn-warning" onclick="bulkEmail()">
                        <i class="fas fa-broadcast-tower me-2"></i>Массовая отправка
                    </button>
                    
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Создать товар
                    </a>
                    
                    <button type="button" class="btn btn-info" onclick="showEmailTemplate()">
                        <i class="fas fa-eye me-2"></i>Просмотр шаблона
                    </button>

                    <button type="button" class="btn btn-danger" onclick="clearQueue()">
                        <i class="fas fa-trash me-2"></i>Очистить очередь
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Статистика
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">{{ \App\Models\Product::count() }}</h4>
                        <small class="text-muted">Всего товаров</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ \App\Models\User::count() }}</h4>
                        <small class="text-muted">Пользователей</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для массовой отправки -->
<div class="modal fade" id="bulkEmailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-broadcast-tower me-2"></i>Массовая отправка уведомлений
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Выберите товары:</label>
                    <select class="form-select" id="bulk-products" multiple>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Используйте Ctrl+Click для выбора нескольких товаров</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Выберите пользователей (необязательно):</label>
                    <select class="form-select" id="bulk-users" multiple>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Если не выбрано, будет использован первый пользователь</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" onclick="sendBulkEmail()">Отправить</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для просмотра шаблона -->
<div class="modal fade" id="emailTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-envelope me-2"></i>Шаблон email уведомления
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Это предварительный просмотр шаблона email уведомления о создании товара.
                </div>
                
                <div class="border rounded p-3 bg-light">
                    <h6>Тема письма:</h6>
                    <p class="mb-3">Новый товар создан: [Название товара]</p>
                    
                    <h6>Содержание включает:</h6>
                    <ul>
                        <li>Информацию о товаре (название, описание, цена, категория)</li>
                        <li>Данные создателя товара</li>
                        <li>Дату и время создания</li>
                        <li>Ссылку на админ-панель</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script>
// Загрузка статуса очередей
function loadQueueStatus() {
    fetch('{{ route("admin.email-settings.queue-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('queue-status').innerHTML = 
                    '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>' + data.error + '</div>';
            } else {
                document.getElementById('queue-status').innerHTML = 
                    '<div class="d-flex align-items-center">' +
                    '<span class="badge ' + (data.redis_connected ? 'bg-success' : 'bg-danger') + ' me-2">' +
                    (data.redis_connected ? 'Подключен' : 'Отключен') + '</span>' +
                    '<small class="text-muted">Redis: ' + data.queue_connection + '</small>' +
                    '</div>';
                
                document.getElementById('emails-queue').textContent = data.emails_queue_size;
                document.getElementById('bulk-emails-queue').textContent = data.bulk_emails_queue_size;
                document.getElementById('default-queue').textContent = data.default_queue_size;
            }
        })
        .catch(error => {
            document.getElementById('queue-status').innerHTML = 
                '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Ошибка подключения к Redis</div>';
        });
}

function testEmail() {
    if (confirm('Отправить тестовое email уведомление через Redis?')) {
        fetch('{{ route("admin.email-settings.test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                loadQueueStatus();
            } else {
                alert('❌ ' + data.error);
            }
        })
        .catch(error => {
            alert('❌ Ошибка отправки: ' + error.message);
        });
    }
}

function bulkEmail() {
    new bootstrap.Modal(document.getElementById('bulkEmailModal')).show();
}

function sendBulkEmail() {
    const productIds = Array.from(document.getElementById('bulk-products').selectedOptions).map(option => parseInt(option.value));
    const userIds = Array.from(document.getElementById('bulk-users').selectedOptions).map(option => parseInt(option.value));
    
    if (productIds.length === 0) {
        alert('Выберите хотя бы один товар!');
        return;
    }
    
    fetch('{{ route("admin.email-settings.bulk") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_ids: productIds,
            user_ids: userIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('bulkEmailModal')).hide();
            loadQueueStatus();
        } else {
            alert('❌ ' + data.error);
        }
    })
    .catch(error => {
        alert('❌ Ошибка массовой отправки: ' + error.message);
    });
}

function clearQueue() {
    const queue = prompt('Введите название очереди для очистки (emails, bulk-emails, default):', 'emails');
    if (queue) {
        if (confirm(`Очистить очередь "${queue}"?`)) {
            fetch('{{ route("admin.email-settings.clear-queue") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ queue: queue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    loadQueueStatus();
                } else {
                    alert('❌ ' + data.error);
                }
            })
            .catch(error => {
                alert('❌ Ошибка очистки очереди: ' + error.message);
            });
        }
    }
}

function showEmailTemplate() {
    new bootstrap.Modal(document.getElementById('emailTemplateModal')).show();
}

// Загружаем статус при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadQueueStatus();
    // Обновляем статус каждые 30 секунд
    setInterval(loadQueueStatus, 30000);
});
</script>
@endsection 