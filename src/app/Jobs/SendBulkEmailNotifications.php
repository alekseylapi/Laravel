<?php

namespace App\Jobs;

use App\Mail\ProductCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $productIds;
    public $userIds;
    public $tries = 2;
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(array $productIds, array $userIds = [])
    {
        $this->productIds = $productIds;
        $this->userIds = $userIds;
        $this->onQueue('bulk-emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Начало массовой отправки email уведомлений', [
                'product_count' => count($this->productIds),
                'user_count' => count($this->userIds)
            ]);

            $products = Product::whereIn('id', $this->productIds)->get();
            $users = !empty($this->userIds) 
                ? User::whereIn('id', $this->userIds)->get() 
                : collect([User::first()]);

            $adminEmail = config('mail.admin_email', 'admin@example.com');
            $sentCount = 0;

            foreach ($products as $product) {
                foreach ($users as $user) {
                    try {
                        Mail::to($adminEmail)
                            ->send(new ProductCreated($product, $user));
                        
                        $sentCount++;
                        
                        Log::info('Массовое уведомление отправлено', [
                            'product_id' => $product->id,
                            'user_id' => $user->id,
                            'sent_count' => $sentCount
                        ]);

                        // Небольшая задержка между отправками
                        sleep(1);
                        
                    } catch (\Exception $e) {
                        Log::error('Ошибка отправки массового уведомления', [
                            'product_id' => $product->id,
                            'user_id' => $user->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

            Log::info('Массовая отправка email завершена', [
                'total_sent' => $sentCount,
                'total_products' => count($products),
                'total_users' => count($users)
            ]);

        } catch (\Exception $e) {
            Log::error('Критическая ошибка массовой отправки email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Обработка неудачной попытки
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Массовая отправка email не удалась', [
            'product_ids' => $this->productIds,
            'user_ids' => $this->userIds,
            'error' => $exception->getMessage()
        ]);
    }
}
