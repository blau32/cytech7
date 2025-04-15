@extends('layouts.app')
<!-- layouts/app.blade.php参照 -->

@section('content')
<!--  @yield('content') app.blade.phpの77行目 に以下のコードが挿入される -->
<div class="register-form">
    <h1 class="register-form__title">ユーザー新規登録画面</h1>

    <div class="register-form__container">
        <form method="POST" action="{{ route('register') }}" class="register-form__form">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @csrf

            <!-- ユーザー名入力欄 -->
            <input
                type="text"
                name="username"
                placeholder="ユーザー名"
                class="register-form__input"
                required
            >
            <!-- メールアドレス入力欄 -->
            <input
                type="email"
                name="email"
                placeholder="メールアドレス"
                class="register-form__input"
                required
            >
            <!-- パスワード入力欄 -->
            <input
                type="password"
                name="password"
                placeholder="パスワード"
                class="register-form__input"
                required
            >
            <!-- パスワード確認入力欄 -->
            <input
                type="password"
                name="password_confirmation"
                placeholder="パスワード（確認用）"
                class="register-form__input"
                required
            >

            <div class="register-form__button-wrapper">
                <button
                    type="submit"
                    class="register-form__register-button"
                >
                    新規登録
                </button>

                <a
                    href="{{ route('login') }}"
                    class="register-form__back-button"
                >
                    戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
