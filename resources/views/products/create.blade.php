@extends('layouts.app')

@section('content')
<div class="product-create">
    <h1 class="product-create__title">商品新規登録画面</h1>

    @if ($errors->any())
    <div class="product-create__errors alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="product-create__wrapper">
        <form
            method="POST"
            action="{{ route('products.store') }}"
            enctype="multipart/form-data"
            class="product-create__form">
            @csrf

            <!-- 商品名 -->
            <div class="product-create__form-item">
                <label for="product_name" class="product-create__label">
                    商品名<span class="product-create__required">*</span>
                </label>
                <input
                    type="text"
                    name="product_name"
                    id="product_name"
                    class="product-create__input"
                    value="{{ old('product_name') }}"
                    required>
            </div>

            <!-- メーカー名 -->
            <div class="product-create__form-item">
                <label for="company_id" class="product-create__label">
                    メーカー名<span class="product-create__required">*</span>
                </label>
                <select
                    name="company_id"
                    id="company_id"
                    class="product-create__select"
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
            <div class="product-create__form-item">
                <label for="price" class="product-create__label">
                    価格<span class="product-create__required">*</span>
                </label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    class="product-create__input"
                    value="{{ old('price') }}"
                    required>
            </div>

            <!-- 在庫数 -->
            <div class="product-create__form-item">
                <label for="stock" class="product-create__label">
                    在庫数<span class="product-create__required">*</span>
                </label>
                <input
                    type="number"
                    name="stock"
                    id="stock"
                    class="product-create__input"
                    value="{{ old('stock') }}"
                    required>
            </div>

            <!-- コメント -->
            <div class="product-create__form-item">
                <label for="comment" class="product-create__label">コメント</label>
                <textarea
                    name="comment"
                    id="comment"
                    class="product-create__textarea">{{ old('comment') }}</textarea>
            </div>

            <!-- 画像 -->
            <div class="product-create__form-item">
                <label for="img_path" class="product-create__label">商品画像</label>
                <input
                    type="file"
                    name="img_path"
                    id="img_path"
                    class="product-create__file">
            </div>

            <!-- ボタン -->
            <div class="product-create__button-wrapper">
                <button type="submit" class="button button--primary">登録</button>
                <a href="{{ route('products.index') }}" class="button button--back">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection