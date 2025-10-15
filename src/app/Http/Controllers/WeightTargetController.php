<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\WeightTargetRequest;
use App\Models\WeightTarget;
use App\Models\WeightLog;

class WeightTargetController extends Controller
{
    //[1]目標体重登録画面（ステップ2）の表示
    public function create()
    {
        if(!session()->has('user_id')){
            return redirect('/register/step1');
        }

        return view('auth.weight_register');
    }

    public function store(WeightTargetRequest $request)
    {
        $userId = session('user_id');
        if(!$userId){
            return redirect('/register/step1');
        }
    //[2]目標体重登録処理
        $weightTarget = WeightTarget::create([
            'user_id' => $userId,
            'target_weight' => $request->target_weight,
        ]);

        WeightLog::create([
            'user_id' => $userId,
            'weight' => $request->current_weight,
            'date' => now(),
        ]);

        session()->forget('user_id');

        return redirect('/weight_logs');
    }

    //[3]目標体重編集画面の表示
    public function edit()
    {

        $user_id = Auth::id();
        $weight_target = WeightTarget::where('user_id', $user_id)->first();
        return view('target_change', compact('weight_target'));
    }

    //[4]目標体重更新処理
    public function update(WeightTargetRequest $request)
    {
        $user_id = Auth::id();
        $weight_target = WeightTarget::where('user_id', $user_id)->first();

        if(!$weight_target){
            WeightTarget::create([
                'user_id' => $user_id,
                'target_weight' => $request->target_weight,
            ]);
        }else{
            $weight_target->update([
                'target_weight' => $request->target_weight,
            ]);
        }
        return redirect('/weight_logs');
    }
}

