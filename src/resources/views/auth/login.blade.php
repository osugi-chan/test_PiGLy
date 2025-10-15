<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}"/>
</head>
<body>
    <div class="login-container">
        <div class="login-title">
        <h2>PiGLy</h2>
        <h3>ログイン</h3>
        </div>

        <div class="login-form">
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" placeholder="パスワードを入力">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="login-button">ログイン</button>
            </div>
        </form>
        </div>

        <p class="register-link">
            <a href="{{ url('/register/step1') }}">アカウント作成はこちら</a>
        </p>
    </div>
</body>
</html>
