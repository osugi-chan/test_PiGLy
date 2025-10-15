<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterUserController extends Controller
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }
    //登録フォームの表示
    public function create()
    {
        return view('auth.register');
    }

    // ユーザー作成処理
    public function store(Request $request, CreatesNewUsers $creator)
    {

        event(new Registered($user = $creator->create($request->all())));

        session(['user_id' => $user->id]);
        return redirect('/register/step2');
    }
}
