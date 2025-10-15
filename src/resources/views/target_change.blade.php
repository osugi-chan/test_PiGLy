@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/target_change.css') }}">
@endsection

@section('content')
<div class="target-change-container">
    <div class="target-change-item">
    <h2 class="target-change-title">目標体重設定</h2>
    <form action="{{ url('/weight_logs/goal_setting') }}" method="POST" class="target-change-form">{{-- '/wight_logs/goal_setting' --}}
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="input-wrapper">
                <input id="target_weight" type="text" name="target_weight" value="{{ old('target_weight',$weight_target->target_weight ) }}" placeholder="目標の体重を入力">{{-- $target_weight->target_weight --}}
                <span class="unit">kg</span>
            </div>
            @error('target_weight')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="button-group">
            <a href="{{ url('/weight_logs') }}" class="back-button">戻る</a>
            <button type="submit" class="change-button">更新</button>
        </div>
    </form>
    </div>
</div>
@endsection
