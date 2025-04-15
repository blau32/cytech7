@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録画面</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="product_form-wrapper">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="product-form">
            @csrf

            <!-- 商品名 -->
            <div class="product_form-item">
                <label for="product_name">商品名<span class="required">*</span></label>
                <input type="text" name="product_name" value="{{ old('product_name') }}">
            </div>

            <!-- メーカー名 -->
            <div class="product_form-item">
                <label for="company_id">メーカー名<span class="required">*</span></label>
                <select name="company_id" id="company_id" required>
                    <option value="">選択してください</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}
                        <!-- <option value="{{ $company->id }}" {{ old('company_id', $product->company_id ?? '') == $company->id ? 'selected' : '' }}> -->
                        @endforeach
                </select>
            </div>

            <!-- 価格 -->
            <div class="product_form-item">
                <label for="price">価格<span class="required">*</span></label>
                <input type="text" name="price" value="{{ old('price', $product->price ?? '') }}">
            </div>

            <!-- 在庫数 -->
            <div class="product_form-item">
                <label for="stock">在庫数<span class="required">*</span></label>
                <input type="text" name="stock" value="{{ old('stock', $product->stock ?? '') }}">
            </div>

            <!-- コメント -->
            <div class="product_form-item">
                <label for="comment">コメント</label>
                <textarea name="comment" id="comment">{{ old('comment', $product->comment ?? '') }}</textarea>
            </div>

            <!-- 商品画像 -->
            <div class="product_form-item">
                <label for="img_path">商品画像</label>
                <input type="file" name="img_path" id="img_path">
            </div>

            <!-- ボタン -->
            <div class="product_form-buttons">
                <button type="submit" class="common-button product_form-submitbutton">新規登録</button>
                <a href="{{ route('products.index') }}">
                    <button type="button" class="common-button product_form-backbutton">戻る</button>
                </a>
            </div>
        </form>
    </div>
    @endsection