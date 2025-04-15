@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title">商品情報編集画面</h1>

    <div class="product-form-wrapper">
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT') <!-- これが重要！PUTリクエストにする -->

            <div class="product-detail__item">
                <label>ID.</label>
                <div>{{ $product->id }}.</div>
            </div>

            <div class="product-form__item">
                <label>商品名<span class="required">*</span></label>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="product-form__item">
                <label>メーカー<span class="required">*</span></label>
                <select name="company_id" required>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="product-form__item">
                <label>価格<span class="required">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="product-form__item">
                <label>在庫数<span class="required">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="product-form__item">
                <label>コメント</label>
                <textarea name="comment">{{ old('comment', $product->comment) }}</textarea>
            </div>

            <div class="product-form__item">
                <label>商品画像</label>
                <input type="file" name="img_path">
            </div>

            <div class="product-form__buttons">
                <button type="submit" class="button-common product-detail__edit-button">更新</button>

                <a href="{{ route('products.index') }}">
                    <button type="button" class="button-common product-detail__back-button">戻る</button>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
