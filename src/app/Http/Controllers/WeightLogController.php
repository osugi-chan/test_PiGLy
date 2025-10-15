<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WeightLogRequest;
use App\Models\WeightLog;
use App\Models\User;
use App\Models\WeightTarget;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;


class WeightLogController extends Controller
{
//[1]管理画面の表示
    public function index()
    {

    $user_id = Auth::id();

    //1：ログイン中の目標体重を1件取得
    $weight_target = WeightTarget::where('user_id', $user_id)
        ->orderBy('created_at','desc')
        ->first();

    //2：ログイン中の人の最新の体重を１件取得
    $latest_log = WeightLog::where('user_id', $user_id)
        ->orderBy('date', 'desc')
        ->first();

    //3：差分の計算
    $weight_difference = null;
        if ($weight_target && $latest_log) {
            $weight_difference = $latest_log->weight - $weight_target->target_weight;
        }
    //4：体重ログを取得(日付の新しい順に並べる)してビューに渡して画面表示
    $weight_logs = WeightLog::where('user_id', $user_id)
        ->orderBy('date', 'desc')
        ->paginate(8)
        ->withPath(Paginator::resolveCurrentPath());

        $count = $weight_logs->total();

        return view('admin',compact(
            'weight_target',
            'latest_log',
            'weight_difference',
            'weight_logs',
            'count'
        ));
    }

    //[2]検索結果の表示
    public function search(Request $request)
    {
        //1：ログイン中のユーザーIDを取得
        $user_id = Auth::id();

        //2：ログイン中のユーザーの目標体重と最新の体重を取得
        $weight_target = WeightTarget::where('user_id', $user_id)->first();

        $latest_log = WeightLog::where('user_id', $user_id)
        ->orderBy('date', 'desc')
        ->first();

        //3：差分の計算
        $weight_difference = null;
        if ($weight_target && $latest_log) {
            $weight_difference = $latest_log->weight - $weight_target->target_weight;
        }

        //4：開始日と終了日をリクエストから取得
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        //5：クエリ作成
        $query = WeightLog::where('user_id', $user_id);

        //6：開始日と終了日の条件をクエリに追加
        if(!empty($start_date)){
            $query->where('date', '>=', $start_date);
        }
        if(!empty($end_date)){
            $query->where('date', '<=', $end_date);
        }
        //7：検索結果を取得(日付の新しい順に並べる)
        $weight_logs = $query->orderBy('date', 'desc')
        ->paginate(8)
        ->withPath(Paginator::resolveCurrentPath())
        ->appends($request->all());

        //8：件数の取得
        $count = $weight_logs->count();

        //9：ビューにデータを渡して画面表示
        return view('admin',compact(
            'weight_target',
            'weight_logs',
            'start_date',
            'end_date',
            'count',
            'weight_difference',
            'latest_log'));
    }

    //[3]体重ログ登録処理
    public function store(WeightLogRequest $request)
    {

        $this->authorize('create', WeightLog::class);

        $validated = $request->validated();

        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'],
            'exercise_time' => $validated['exercise_time'],
            'exercise_content' => $validated['exercise_content'],
        ]);

        return redirect('/weight_logs');
    }

    //[4]編集画面の表示
    public function edit($weightLogId)
    {
        $weight_log = WeightLog::findOrFail($weightLogId);

        $this->authorize('view', $weight_log);

        return view('update', compact('weight_log'));
    }

    //[5]体重ログ更新処理
    public function update(WeightLogRequest $request, $weightLogId)
    {
        $weight_log = WeightLog::findOrFail($weightLogId);

        $this->authorize('update', $weight_log);

        $validated = $request->validated();
        $weight_log->update([
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'],
            'exercise_time' => $validated['exercise_time'],
            'exercise_content' => $validated['exercise_content'],
        ]);

        return redirect('/weight_logs');
    }

    //[6]体重ログ削除処理
    public function destroy($weightLogId)
    {
        //1：IDをもとに体重ログを取得
        $weight_log = WeightLog::findOrFail($weightLogId);

        //2：ポリシーで認可
        $this->authorize('delete', $weight_log);

        //3：削除処理
        $weight_log->delete();

        //4：管理画面へリダイレクト
        return redirect('/weight_logs');

    }
}
