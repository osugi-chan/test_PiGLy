<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}"/>
</head>

<body>
<div class="register-container">
    <div class="register-title">
    <h2>PiGLy</h2>
    <h3>新規会員登録</h3>
    </div>
    <p class="register-title-item">STEP1 アカウント情報の登録</p>

    <div class="register-form">
    <form method="POST" action="/register/step1">
        @csrf
        <div class="form-group">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="名前を入力">
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

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
            <button type="submit" class="register-button">次に進む</button>
        </div>
    </form>
    </div>

    <p class="login-link">
        <a href="{{ asset('/login') }}">ログインはこちら</a>
    </p>
</div>
</body>
</html>
