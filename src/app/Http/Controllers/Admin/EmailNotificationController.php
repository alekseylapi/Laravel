<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkEmailNotifications;
use App\Jobs\SendProductCreatedNotification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class EmailNotificationController extends Controller
{
    public function index(): View
    {
        return view('admin.email-settings');
    }

    public function testNotification(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = $request->input('user_id');

        if (!$productId) {
            $product = Product::first();
            if (!$product) {
                return response()->json(['error' => 'Товары не найдены'], 404);
            }
        } else {
            $product = Product::find($productId);
            if (!$product) {
                return response()->json(['error' => "Товар с ID {$productId} не найден"], 404);
            }
        }

        if (!$userId) {
            $user = User::first();
            if (!$user) {
                return response()->json(['error' => 'Пользователи не найдены'], 404);
            }
        } else {
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => "Пользователь с ID {$userId} не найден"], 404);
            }
        }

        try {
            SendProductCreatedNotification::dispatch($product, $user);
            
            return response()->json([
                'success' => true,
                'message' => 'Тестовое уведомление отправлено в очередь Redis',
                'data' => [
                    'product' => $product->name,
                    'user' => $user->name,
                    'admin_email' => config('mail.admin_email')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка отправки уведомления: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkNotification(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id'
        ]);

        try {
            SendBulkEmailNotifications::dispatch(
                $request->product_ids,
                $request->user_ids ?? []
            );

            return response()->json([
                'success' => true,
                'message' => 'Массовая отправка уведомлений запущена',
                'data' => [
                    'product_count' => count($request->product_ids),
                    'user_count' => count($request->user_ids ?? [])
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка массовой отправки: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getQueueStatus()
    {
        try {
            $redis = Redis::connection();
            
            $queueStats = [
                'emails_queue_size' => $redis->lLen('queues:emails'),
                'bulk_emails_queue_size' => $redis->lLen('queues:bulk-emails'),
                'default_queue_size' => $redis->lLen('queues:default'),
                'redis_connected' => $redis->ping() === '+PONG',
                'admin_email' => config('mail.admin_email'),
                'queue_connection' => config('queue.default')
            ];

            return response()->json($queueStats);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка получения статуса очередей: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clearQueue(Request $request)
    {
        $queue = $request->input('queue', 'emails');
        
        try {
            $redis = Redis::connection();
            $redis->del("queues:{$queue}");
            
            return response()->json([
                'success' => true,
                'message' => "Очередь '{$queue}' очищена"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка очистки очереди: ' . $e->getMessage()
            ], 500);
        }
    }
}
