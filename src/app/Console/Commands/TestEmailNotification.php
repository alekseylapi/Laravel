<?php

namespace App\Console\Commands;

use App\Jobs\SendProductCreatedNotification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-notification {--product-id=} {--user-id=} {--check-redis}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирование отправки email уведомлений через Redis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Проверка Redis подключения
        if ($this->option('check-redis')) {
            $this->checkRedisConnection();
            return 0;
        }

        $productId = $this->option('product-id');
        $userId = $this->option('user-id');

        if (!$productId) {
            $product = Product::first();
            if (!$product) {
                $this->error('Товары не найдены в базе данных!');
                return 1;
            }
        } else {
            $product = Product::find($productId);
            if (!$product) {
                $this->error("Товар с ID {$productId} не найден!");
                return 1;
            }
        }

        if (!$userId) {
            $user = User::first();
            if (!$user) {
                $this->error('Пользователи не найдены в базе данных!');
                return 1;
            }
        } else {
            $user = User::find($userId);
            if (!$user) {
                $this->error("Пользователь с ID {$userId} не найден!");
                return 1;
            }
        }

        $this->info("🔍 Проверка Redis подключения...");
        if (!$this->checkRedisConnection()) {
            return 1;
        }

        $this->info("📧 Отправка тестового уведомления через Redis...");
        $this->info("📦 Товар: {$product->name}");
        $this->info("👤 Пользователь: {$user->name} ({$user->email})");
        $this->info("📮 Email получателя: " . config('mail.admin_email', 'admin@example.com'));
        $this->info("🔗 Очередь: emails");

        try {
            SendProductCreatedNotification::dispatch($product, $user);
            
            $this->info('✅ Уведомление успешно отправлено в Redis очередь!');
            
            // Показываем статистику очередей
            $this->showQueueStats();
            
        } catch (\Exception $e) {
            $this->error('❌ Ошибка отправки уведомления: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Проверка подключения к Redis
     */
    private function checkRedisConnection(): bool
    {
        try {
            $redis = Redis::connection();
            $response = $redis->ping();
            
            if ($response === '+PONG') {
                $this->info('✅ Redis подключение успешно');
                return true;
            } else {
                $this->error('❌ Redis не отвечает корректно');
                return false;
            }
        } catch (\Exception $e) {
            $this->error('❌ Ошибка подключения к Redis: ' . $e->getMessage());
            $this->line('💡 Убедитесь, что Redis запущен и доступен на порту 6379');
            return false;
        }
    }

    /**
     * Показать статистику очередей
     */
    private function showQueueStats(): void
    {
        try {
            $redis = Redis::connection();
            
            $emailsQueue = $redis->lLen('queues:emails');
            $bulkEmailsQueue = $redis->lLen('queues:bulk-emails');
            $defaultQueue = $redis->lLen('queues:default');
            
            $this->newLine();
            $this->info('📊 Статистика очередей Redis:');
            $this->line("   📧 Email очередь: {$emailsQueue} задач");
            $this->line("   📨 Массовые email: {$bulkEmailsQueue} задач");
            $this->line("   🔄 Общая очередь: {$defaultQueue} задач");
            
            if ($emailsQueue > 0) {
                $this->warn('⚠️  В очереди есть необработанные задачи. Запустите: php artisan queue:work redis --queue=emails');
            }
            
        } catch (\Exception $e) {
            $this->warn('⚠️  Не удалось получить статистику очередей: ' . $e->getMessage());
        }
    }
}
