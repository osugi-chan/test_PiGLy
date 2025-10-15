@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/update.css') }}">
@endsection

@section('content')
<div class="update-container">
    <div class="update-form-contents">
        <h2 class="update-title">Weight Log</h2>
        <form action="{{ url('/weight_logs/' . $weight_log->id . '/update') }}" method="POST" class="update-form">
        @csrf
            <div class="update-form-group">
                <label for="date">日付</label>
                <input type="date" id="date" name="date" value="{{ old('date',$weight_log->date) }}">
                @error('date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="update-form-group">
                <label for="weight">体重</label>
                <div class="input-with-unit">
                    <input type="text" id="weight" name="weight" value="{{ old('weight',$weight_log->weight) }}">
                    <p class="unit">kg</p>
                </div>
                    @error('weight')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
            </div>

            <div class="update-form-group">
                <label for="calories">摂取カロリー</label>
                <div class="input-with-unit">
                    <input type="text" id="calories" name="calories" value="{{ old('calories',$weight_log->calories) }}">
                    <p class="unit">cal</p>
                </div>
                    @error('calories')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
            </div\>

            <div class="update-form-group">
                <label for="exercise_time">運動時間</label>
                <input type="text" id="exercise_time" name="exercise_time" value="{{ old('exercise_time',$weight_log->exercise_time) }}">
                    @error('exercise_time')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
            </div>

            <div class="update-form-group">
                <label for="exercise_content">運動内容</label>
                <textarea id="exercise_content" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content',$weight_log->exercise_content) }}</textarea>
                @error('exercise_content')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-group">
                <a class="back-button" href="{{ url('/weight_logs') }}" class="back-button">戻る</a>
                <button type="submit" class="update-button">追加</button>
                <a href="{{ url('/weight_logs/' . $weight_log->id . '/delete') }} " class="trash-can-icon">
                    <img src="{{ asset('images/trash-can.png') }}" alt="ゴミ箱アイコン">
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
