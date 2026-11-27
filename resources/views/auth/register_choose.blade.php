<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ОНМК | Выбор роли для регистрации</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.min.css">

    <style>
        .register-choose-page {
            min-height: 100vh;
            height: auto;
            padding: 2rem 1rem;
        }

        .register-choose-box {
            width: 100%;
            max-width: 760px;
        }

        .role-card {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            color: #212529;
            text-decoration: none;
            border: 2px solid #dee2e6;
            border-radius: 0.5rem;
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .role-card:hover,
        .role-card:focus-visible {
            color: #212529;
            text-decoration: none;
            transform: translateY(-4px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12);
        }

        .role-card--patient:hover,
        .role-card--patient:focus-visible {
            border-color: #007bff;
        }

        .role-card--doctor:hover,
        .role-card--doctor:focus-visible {
            border-color: #117a8b;
        }

        .role-card:focus-visible {
            outline: 3px solid rgba(0, 123, 255, 0.45);
            outline-offset: 2px;
        }

        .role-card--doctor:focus-visible {
            outline-color: rgba(17, 122, 139, 0.45);
        }

        .role-card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
        }

        .role-card--patient .role-card-icon {
            background-color: #e8f1ff;
            color: #0056b3;
        }

        .role-card--doctor .role-card-icon {
            background-color: #e6f6f8;
            color: #0c6e7d;
        }

        .role-card-title {
            font-size: 1.35rem;
            font-weight: 600;
            color: #1f2d3d;
            margin-bottom: 0.75rem;
        }

        .role-card-text {
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            margin-bottom: 1.5rem;
        }

        .role-card-cta {
            font-size: 1rem;
            font-weight: 600;
            padding: 0.65rem 1rem;
            transition: background-color 0.18s ease, border-color 0.18s ease;
        }

        .role-card--patient:hover .role-card-cta,
        .role-card--patient:focus-visible .role-card-cta {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-doctor {
            color: #ffffff;
            background-color: #117a8b;
            border-color: #10707f;
        }

        .role-card--doctor:hover .btn-doctor,
        .role-card--doctor:focus-visible .btn-doctor {
            color: #ffffff;
            background-color: #0d5d6a;
            border-color: #0b515c;
        }
    </style>
</head>
<body class="hold-transition register-page register-choose-page">
<div class="register-choose-box">
    <div class="login-logo mb-2">
        <a href="{{ route('home') }}">Реабилитация после ОНМК</a>
    </div>
    <p class="text-center text-secondary mb-4" style="font-size: 1.05rem;">
        Выберите роль для создания учётной записи
    </p>

    <div class="row align-items-stretch">
        <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex">
            <a href="{{ route('auth.register') }}" class="card role-card role-card--patient">
                <div class="card-body d-flex flex-column text-center p-4">
                    <div class="role-card-icon">
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </div>
                    <h2 class="role-card-title">Пациент / Родственник</h2>
                    <p class="role-card-text flex-grow-1">
                        Доступ к реабилитационным тренажёрам, занятиям и отслеживанию прогресса.
                    </p>
                    <span class="btn btn-primary btn-block role-card-cta mt-auto">
                        Продолжить <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 d-flex">
            <a href="{{ route('auth.register_doc') }}" class="card role-card role-card--doctor">
                <div class="card-body d-flex flex-column text-center p-4">
                    <div class="role-card-icon">
                        <i class="fas fa-user-md" aria-hidden="true"></i>
                    </div>
                    <h2 class="role-card-title">Врач / Специалист</h2>
                    <p class="role-card-text flex-grow-1">
                        Ведение списка пациентов, просмотр результатов и контроль реабилитации.
                    </p>
                    <span class="btn btn-doctor btn-block role-card-cta mt-auto">
                        Продолжить <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>

    <div class="text-center mt-4" style="font-size: 1rem;">
        Уже есть аккаунт?
        <a href="{{ route('login') }}" class="font-weight-bold ml-1">Войти</a>
    </div>
</div>

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.min.js"></script>
</body>
</html>
