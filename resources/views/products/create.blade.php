@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録画面</h1>

    <div class="product-form-wrapper">
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="product-form">
        @csrf

        <!-- 商品名 -->
        <div class="product-form__item">
            <label for="product_name">商品名<span class="required">*</span></label>
            <input type="text" name="product_name" id="product_name" required>
        </div>

        <!-- メーカー名 -->
        <div class="product-form__item">
            <label for="company_id">メーカー名<span class="required">*</span></label>
            <select name="company_id" id="company_id" required>
                <option value="">選択してください</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- 価格 -->
        <div class="product-form__item">
            <label for="price">価格<span class="required">*</span></label>
            <input type="number" name="price" id="price" required>
        </div>

        <!-- 在庫数 -->
        <div class="product-form__item">
            <label for="stock">在庫数<span class="required">*</span></label>
            <input type="number" name="stock" id="stock" required>
        </div>

        <!-- コメント -->
        <div class="product-form__item">
            <label for="comment">コメント</label>
            <textarea name="comment" id="comment"></textarea>
        </div>

        <!-- 商品画像 -->
        <div class="product-form__item">
            <label for="img_path">商品画像</label>
            <input type="file" name="img_path" id="img_path">
        </div>

        <!-- ボタン -->
        <div class="product-form__buttons">
            <button type="submit" class="product-form__submit-button">新規登録</button>
            <a href="{{ route('products.index') }}">
                <button type="button" class="product-form__back-button">戻る</button>
            </a>
        </div>
    </form>
</div>
@endsection
