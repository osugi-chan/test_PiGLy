<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        /*Fortify::registerView(function() {
            return view('auth.register');
        });*/

        Fortify::loginView(function () {
            return view('auth.login');
        });

        //ログイン時のバリデーションとメッセージ設定
        Fortify::authenticateUsing(function ($request){

            $validator = Validator::make($request->all(),[
                'email' => ['required','email'],
                'password' => ['required','string','min:8'],
            ],
            [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスは「ユーザー名＠ドメイン」形式で入力してください',
                'password.required' =>'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
            ]);

            $validator->validate();

            $user = User::where('email',$request->email)->first();
            if(! $user || ! Hash::check($request->password,$user->password)){
                throw ValidationException::withMessages([
                'email' => ['メールアドレスまたはパスワードが正しくありません'],
            ]);
            }

            return $user;
        });

        $this->app->singleton(RegisterResponseContract::class,function()
        {
            return new class implements RegisterResponseContract
            {
                public function toResponse($request)
                {
                    return redirect('/register/step2');
                }
            };
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email.$request->ip());
        }); //1分間に10回までログイン試行可能

    }
}
