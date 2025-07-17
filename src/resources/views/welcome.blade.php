<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .hero-content {
            text-align: center;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 0 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary-hero {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
        }
        .btn-primary-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .btn-secondary-hero {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }
        .btn-secondary-hero:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .features {
            padding: 80px 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <i class="fas fa-cogs me-3"></i>
                    Система управления
                </h1>
                <p class="hero-subtitle">
                    Современная платформа для управления категориями и продуктами
                </p>
                
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                        <i class="fas fa-sign-in-alt me-2"></i>Войти
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero btn-secondary-hero">
                        <i class="fas fa-user-plus me-2"></i>Регистрация
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-tags feature-icon"></i>
                        <h4>Управление категориями</h4>
                        <p>Создавайте и управляйте категориями товаров с удобным интерфейсом</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-box feature-icon"></i>
                        <h4>Управление продуктами</h4>
                        <p>Добавляйте, редактируйте и удаляйте продукты с полным контролем</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>Аналитика</h4>
                        <p>Отслеживайте статистику и анализируйте данные в реальном времени</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
