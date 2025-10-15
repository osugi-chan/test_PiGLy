
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/auth/weight_register.css') }}"/>
</head>
<body>
    <div class="weight_register-container">
        <div class="register-title">
        <h2>PiGLy</h2>
        <h3>新規会員登録</h3>
        </div>
        <p class="register-title-item">STEP2 体重データの入力</p>
        <div class="register-form">
        <form action="/register/step2" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_weight">現在の体重</label>
                <div class="input-with-unit">
                    <input id="current_weight" type="text" name="current_weight" value="{{ old('current_weight') }}" placeholder="現在の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('current_weight')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="target_weight">目標体重</label>
                <div class="input-with-unit">
                    <input id="target_weight" type="text" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('target_weight')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="register-button">アカウント作成</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
