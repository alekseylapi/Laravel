<?php

namespace App\Jobs;

use App\Mail\ProductCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendProductCreatedNotification implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $user;
    public $tries = 3; // Количество попыток
    public $timeout = 30; // Таймаут в секундах
    public $backoff = [10, 30, 60]; // Задержка между попытками

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
        $this->onQueue('emails'); // Отдельная очередь для email
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Отправка email уведомления о создании товара', [
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
                'user_id' => $this->user->id,
                'user_email' => $this->user->email,
                'admin_email' => config('mail.admin_email')
            ]);

            Mail::to(config('mail.admin_email', 'admin@example.com'))
                ->send(new ProductCreated($this->product, $this->user));

            Log::info('Email уведомление успешно отправлено', [
                'product_id' => $this->product->id,
                'admin_email' => config('mail.admin_email')
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка отправки email уведомления', [
                'product_id' => $this->product->id,
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e; // Повторяем попытку
        }
    }

    /**
     * Уникальность задачи (не отправляем дубликаты для одного товара)
     */
    public function uniqueId()
    {
        return 'product_created_' . $this->product->id;
    }

    /**
     * Время жизни уникальности (24 часа)
     */
    public function uniqueFor()
    {
        return 86400; // 24 часа в секундах
    }

    /**
     * Обработка неудачной попытки
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email уведомление не удалось отправить после всех попыток', [
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'error' => $exception->getMessage()
        ]);
    }
}
