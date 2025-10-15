@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="admin-container">
    <div class="weight_status">{{-- 体重ステータス --}}
        <div class="weight_status-item">
            <p class="label">目標体重</p>
            <p class="value">
                @if($weight_target)
                {{ $weight_target->target_weight }}kg
                @else
                -
                @endif
            </p>
        </div>

        <span class="divider"></span>

        <div class="weight_status-item">
            <p class="label">目標まで</p>
            <p class="value">
                @if(!is_null($weight_difference))
                    {{ number_format($weight_difference,1) }}kg
                @else
                    -
                @endif
            </p>
        </div>

        <span class="divider"></span>

        <div class="weight_status-item">
            <p class="label">最新体重</p>
            <p class="value">
                @if($latest_log)
                {{ $latest_log->weight }}kg
                @else
                -
                @endif
            </p>
        </div>
    </div>

    <div class="weiht_log-container">
        <div class="container-item">
            <div class="weight-search">
                <div class="weight-search-item">{{-- 検索フォーム --}}
                <form action="/weight_logs/search" method="POST" class="weight-search-form">
                @csrf
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" placeholder="年/月/日">
                    <p>～</p>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" placeholder="年/月/日">

                    <div class="buttons">
                        <button type="submit" class="search-button">検索</button>
                        @if(request('start_date') || request('end_date'))<!-- リセットボタン -->
                        <a href="{{ url('/weight_logs') }}" class="reset-button">リセット</a>
                        @endif
                    </div>
                </form>
                </div>

                <div class="links">{{-- データ追加モーダル --}}
                    <button id="openModal">データを追加</button>
                </div>
            </div>

            <div class="modal" id="weightModal"style="display: none;">
                <div class="modal__content">
                    <h2 class="modal__title">Weight Logを追加</h2>
                    <form action="/weight_logs/create" method="POST" class="modal__form">
                    @csrf
                        <div class="modal-form-group">
                            <label for="date">日付<span class="required">必須</span></label>
                            <input type="date" id="date" name="date" value="{{ old('date') }}">
                            @error('date')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="modal-form-group">
                            <label for="weight">体重<span class="required">必須</span></label>
                            <div class="input-with-unit">
                                <input type="text" id="weight" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                                <p class="unit">kg</p>
                            </div>
                            @error('weight')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="modal-form-group">
                            <label for="calories">摂取カロリー<span class="required">必須</span></label>
                            <div class="input-with-unit">
                                <input type="text" id="calories" name="calories" value="{{ old('calories') }}" placeholder="1200">
                                <p class="unit">cal</p>
                            </div>
                            @error('calories')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="modal-form-group">
                            <label for="exercise_time">運動時間<span class="required">必須</span></label>
                            <input type="text" id="exercise_time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="00:00">
                            @error('exercise_time')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="modal-form-group">
                            <label for="exercise_content">運動内容</label>
                            <textarea id="exercise_content" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                            @error('exercise_content')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="button-group">
                            <button type="button" id="closeModal" class="back-button">戻る</button>
                        <button type="submit" class="submit-button">追加</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="search-results-message">{{-- 検索結果の表示 --}}
            @if(isset($start_date) && isset($end_date) )
                <p>{{ $start_date }} 〜 {{ $end_date }} の検索結果</p>
                <p>{{ $count ?? 0 }}件</p>
            @elseif(isset($start_date))
                <p>{{ $start_date }} 以降の検索結果</p>
                <p>{{ $count ?? 0 }}件</p>
            @elseif(isset($end_date))
                <p>{{ $end_date}} 以前の検索結果</p>
                <p>{{ $count ?? 0 }}件</p>
            @else
                <p>全てのデータ</p>
                <p>{{ $count ?? 0 }}件</p>
            @endif
        </div>

        <div class="weight-logs">{{-- 体重ログ一覧 --}}
            <table class="weight-logs-table">
                <tr class="table-header">
                    <th class="date">日付</th>
                    <th class="weight">体重</th>
                    <th class="calories">食事摂取カロリー</th>
                    <th class="exercise-time">運動時間</th>
                    <th></th>
                </tr>
                @foreach ( $weight_logs as $log )
                <tr class="table-data">
                    <td class="date">{{ $log->date }}</td>
                    <td class="weight">{{ $log->weight }}kg</td>
                    <td class="calories">{{ $log->calories }}cal</td>
                    <td class="exercise-time">{{ $log->exercise_time }}分</td>
                    <td>
                        <a href="/weight_logs/{{ $log->id }}">
                            <img src="{{ asset('/images/icon_pencil.png') }}" alt="詳細アイコン">
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="pagination-content">{{-- ページネーション設定 --}}
            {{ $weight_logs->links('pagination::bootstrap-4') }} {{-- $weight_logs->links() --}}
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('weightModal');
    document.getElementById('openModal').addEventListener('click', () => modal.style.display = 'block');
    document.getElementById('closeModal').addEventListener('click', () => modal.style.display = 'none');

    @if ($errors->any())
        modal.style.display = 'block';
    @endif
</script>

@endsection
