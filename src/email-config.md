# Настройка Email уведомлений

## Конфигурация

Для работы email уведомлений необходимо настроить следующие параметры в файле `.env`:

```env
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

## Настройка Gmail

1. Включите двухфакторную аутентификацию в Google аккаунте
2. Создайте пароль приложения:
   - Перейдите в настройки безопасности Google
   - Выберите "Пароли приложений"
   - Создайте новый пароль для Laravel
3. Используйте этот пароль в `MAIL_PASSWORD`

## Настройка очередей (рекомендуется)

Для асинхронной отправки email добавьте в `.env`:

```env
QUEUE_CONNECTION=database
```

И запустите миграцию для таблицы очередей:

```bash
php artisan queue:table
php artisan migrate
```

Запуск обработчика очередей:

```bash
php artisan queue:work
```

## Тестирование

Для тестирования email уведомлений используйте команду:

```bash
php artisan test:email-notification
```

Или с указанием конкретных ID:

```bash
php artisan test:email-notification --product-id=1 --user-id=1
```

## Локальная разработка

Для локальной разработки можно использовать Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
``` 