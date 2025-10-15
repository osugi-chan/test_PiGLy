<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>体重管理画面</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>
<body>
    <div class="app">
        <header class="header">
            <h1 class="header__heading">PiGLy</h1>
            <div class="header_button">
            <p class="goal_setting_button">
                <a class="goal_setting_button_text" href="{{ url('/weight_logs/goal_setting') }}"><i class="fa-solid fa-gear"></i> 目標体重設定</a>
            </p>
            <form  class="logout-form" action="{{ route('logout') }}" method="POST" style="inline">
                @csrf
                <button class="logout__button" type="submit">
                    <i class="fa-solid fa-door-open"></i> ログアウト
                </button>
            </form>
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
