# Настройка Redis для Email уведомлений

## Конфигурация Redis

Для работы email уведомлений через Redis необходимо настроить следующие параметры в файле `.env`:

```env
# Redis настройки
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1

# Очереди через Redis
QUEUE_CONNECTION=redis
REDIS_QUEUE_CONNECTION=default
REDIS_QUEUE=default
REDIS_QUEUE_RETRY_AFTER=90

# Email настройки
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Email администратора для получения уведомлений
ADMIN_EMAIL=admin@example.com
```

## Docker Compose для Redis

Если используете Docker, добавьте в `docker-compose.yml`:

```yaml
version: '3.8'
services:
  redis:
    image: redis:7-alpine
    container_name: laravel_redis
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data
    command: redis-server --appendonly yes
    networks:
      - laravel_network

volumes:
  redis_data:

networks:
  laravel_network:
    driver: bridge
```

## Запуск очередей

### 1. Обработчик очередей Redis
```bash
php artisan queue:work redis --queue=emails,bulk-emails,default
```

### 2. Мониторинг очередей
```bash
# Просмотр статуса очередей
php artisan queue:monitor

# Просмотр неудачных задач
php artisan queue:failed

# Повторная попытка неудачных задач
php artisan queue:retry all
```

### 3. Очистка очередей
```bash
# Очистка всех очередей
php artisan queue:flush

# Очистка неудачных задач
php artisan queue:flush --failed
```

## Тестирование Redis

### 1. Проверка подключения
```bash
php artisan tinker
>>> Redis::ping()
# Должно вернуть "+PONG"
```

### 2. Тестирование очередей
```bash
# Тестовая отправка email
php artisan test:email-notification

# Проверка размера очередей
php artisan tinker
>>> Redis::lLen('queues:emails')
>>> Redis::lLen('queues:bulk-emails')
```

## Мониторинг через админ-панель

1. Перейдите в админ-панель: `/admin/email-settings`
2. Проверьте статус подключения к Redis
3. Просмотрите статистику очередей
4. Протестируйте отправку уведомлений

## Преимущества Redis

### 🚀 **Производительность:**
- Быстрая обработка очередей
- Низкая задержка
- Высокая пропускная способность

### 🔄 **Надежность:**
- Персистентность данных
- Автоматическое восстановление
- Обработка ошибок

### 📊 **Мониторинг:**
- Статистика очередей в реальном времени
- Отслеживание неудачных задач
- Логирование всех операций

### 🎯 **Функциональность:**
- Уникальные задачи (без дубликатов)
- Приоритетные очереди
- Отложенная отправка
- Массовая обработка

## Команды для управления

```bash
# Запуск обработчика с приоритетами
php artisan queue:work redis --queue=high,emails,bulk-emails,default

# Запуск в фоновом режиме
php artisan queue:work redis --daemon

# Остановка обработчика
php artisan queue:restart

# Просмотр логов
tail -f storage/logs/laravel.log
```

## Troubleshooting

### Проблема: Redis не подключается
```bash
# Проверьте статус Redis
docker ps | grep redis

# Проверьте порты
netstat -an | grep 6379

# Проверьте конфигурацию
php artisan config:cache
```

### Проблема: Очереди не обрабатываются
```bash
# Проверьте статус обработчика
ps aux | grep "queue:work"

# Перезапустите обработчик
php artisan queue:restart

# Проверьте логи
tail -f storage/logs/laravel.log
```

### Проблема: Email не отправляются
```bash
# Проверьте настройки SMTP
php artisan tinker
>>> Mail::raw('Test', function($message) { $message->to('test@example.com'); });

# Проверьте очередь
php artisan queue:failed
``` 