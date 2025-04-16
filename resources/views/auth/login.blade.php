<!-- ログイン画面 -->
@extends('layouts.app')
<!-- layouts/app.blade.php参照 -->

@section('content')
<!--  @yield('content') app.blade.appの77行目 に以下のコードが挿入される -->
<div class="login-form">
    <h1 class="login-form__title">ユーザーログイン画面</h1>
    <div class="login-form__container">
        <!-- バリデーション -->
        @if ($errors->any()) <!--  -->
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="login-form__form">
            @csrf

            <!-- メールアドレス入力欄 -->
            <input
                type="email"
                name="email"
                placeholder="メールアドレス"
                class="login-form__input">

            <!-- パスワード入力欄 -->
            <input
                type="password"
                name="password"
                placeholder="パスワード"
                class="login-form__input">

            <!-- ボタン -->
            <div class="login-form__button-wrapper">

                <!-- 新規登録ボタン -->
                <a href="{{ route('register') }}" class="login-form__button login-form__button--register">新規登録</a>

                <!-- ログインボタン -->
                <button type="submit" class="login-form__button login-form__button--submit">ログイン</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@endsection