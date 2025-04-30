@extends('layouts.app')

@section('content')
<div class="main-container">
    <h1 class="product-common__title">商品新規登録画面</h1>

    @if ($errors->any())
    <div class="product-common__errors alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="product-common__wrapper">
        <form
            method="POST"
            action="{{ route('products.store') }}"
            enctype="multipart/form-data"
            class="product-common__form">
            @csrf

            <!-- 商品名 -->
            <div class="product-common__form-item">
                <label for="product_name" class="product-common__label">
                    商品名<span class="product-common__required">*</span>
                </label>
                <input
                    type="text"
                    name="product_name"
                    id="product_name"
                    class="product-common__input"
                    value="{{ old('product_name') }}"
                    required>
            </div>

            <!-- メーカー名 -->
            <div class="product-common__form-item">
                <label for="company_id" class="product-common__label">
                    メーカー名<span class="product-common__required">*</span>
                </label>
                <select
                    name="company_id"
                    id="company_id"
                    class="product-common__select"
                    required>
                    <option value="">選択してください</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- 価格 -->
            <div class="product-common__form-item">
                <label for="price" class="product-common__label">
                    価格<span class="product-common__required">*</span>
                </label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    class="product-common__input"
                    value="{{ old('price', $product->price ?? '') }}"
                    min="0"
                    step="1"
                    required>
            </div>

            <!-- 在庫数 -->
            <div class="product-common__form-item">
                <label for="stock" class="product-common__label">
                    在庫数<span class="product-common__required">*</span>
                </label>
                <input
                    type="number"
                    name="stock"
                    id="stock"
                    class="product-common__input"
                    value="{{ old('stock', $product->stock ?? '') }}"
                    min="0"
                    step="1"
                    required>
            </div>

            <!-- コメント -->
            <div class="product-common__form-item">
                <label for="comment" class="product-common__label">コメント</label>
                <textarea
                    name="comment"
                    id="comment"
                    class="product-common__textarea">{{ old('comment') }}</textarea>
            </div>

            <!-- 商品画像選択 -->
            <div class="product-common__form-item">
                <label for="img_path" class="product-common__label">商品画像</label>
                <input
                    type="file"
                    name="img_path"
                    id="img_path"
                    class="product-common__file"
                    accept="image/*"
                    onchange="previewImage(event)">
            </div>

            <!-- プレビュー表示用 -->
            <div class="product-common__form-item">
                <label class="product-common__label"></label>
                <img id="preview" src="" alt="プレビュー画像" style="max-width: 200px; display: none;">
            </div>
            <!-- ボタン -->
            <div class="product-common__button-wrapper">
                <button type="submit" class="button product-common__button--primary">新規登録</button>
                <a href="{{ route('products.index') }}" class="button product-common__button--back">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection