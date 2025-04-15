<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        // guestミドルウェアは、「ログイン済みユーザーは、このページに入れない」 という制御をする
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([ //バリデーション
            'username' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([ //バリデーションが成功した場合のみユーザー作成処理
            'username' => $validatedData['username'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), //ハッシュ化
        ]);

        return redirect()->route('login')->with('success', 'ユーザー登録が完了しました。'); //画面遷移
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
