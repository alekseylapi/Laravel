<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новый товар создан</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .product-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 10px;
        }
        .product-details {
            margin: 15px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        .detail-value {
            color: #333;
        }
        .user-info {
            background-color: #e8f5e8;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
        .timestamp {
            color: #999;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛍️ Новый товар создан</h1>
            <p>Уведомление о создании нового товара в системе</p>
        </div>
        
        <div class="content">
            <p>Здравствуйте!</p>
            
            <p>В системе был создан новый товар. Ниже представлена подробная информация:</p>
            
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                
                <div class="product-details">
                    @if($product->description)
                    <div class="detail-row">
                        <span class="detail-label">Описание:</span>
                        <span class="detail-value">{{ $product->description }}</span>
                    </div>
                    @endif
                    
                    @if($product->price)
                    <div class="detail-row">
                        <span class="detail-label">Цена:</span>
                        <span class="detail-value">{{ number_format($product->price, 2) }} ₽</span>
                    </div>
                    @endif
                    
                    @if($product->category)
                    <div class="detail-row">
                        <span class="detail-label">Категория:</span>
                        <span class="detail-value">{{ $product->category->name }}</span>
                    </div>
                    @endif
                    
                    <div class="detail-row">
                        <span class="detail-label">Дата создания:</span>
                        <span class="detail-value">{{ $product->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="user-info">
                <strong>👤 Создатель товара:</strong><br>
                <strong>Имя:</strong> {{ $user->name }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y') }}
            </div>
            
            <p>Для просмотра и редактирования товара перейдите в админ-панель:</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/admin/products') }}" class="btn">Перейти в админ-панель</a>
            </div>
            
            <div class="timestamp">
                Уведомление отправлено: {{ now()->format('d.m.Y H:i:s') }}
            </div>
        </div>
        
        <div class="footer">
            <p>Это автоматическое уведомление. Пожалуйста, не отвечайте на это письмо.</p>
            <p>&copy; {{ date('Y') }} Система управления товарами. Все права защищены.</p>
        </div>
    </div>
</body>
</html> 