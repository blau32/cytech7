@extends('layouts.app')

@section('content')
<div class="main-container">
    <h1 class="product-common__title">商品情報詳細画面</h1>

    <div class="product-common__wrapper">
        <!-- 商品ID -->
        <div class="product-show__item">
            <label class="product-common__label ">ID</label>
            <div class="product-show__value">{{ $product->id }}.</div>
        </div>

        <!-- 商品画像 -->
        <div class="product-show__item">
            <label class="product-common__label ">商品画像</label>
            <div class="product-show__value">
                @if ($product->img_path)
                <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" class="product-show__image">
                @else
                <span class="product-show__value">画像なし</span>
                @endif
            </div>
        </div>

        <!-- 商品名 -->
        <div class="product-show__item">
            <label class="product-common__label ">商品名</label>
            <div class="product-show__value">{{ $product->product_name }}</div>
        </div>

        <!-- メーカー名 -->
        <div class="product-show__item">
            <label class="product-common__label ">メーカー名</label>
            <div class="product-show__value">{{ $product->company->company_name ?? '' }}</div>
        </div>

        <!-- 価格 -->
        <div class="product-show__item">
            <label class="product-common__label ">価格</label>
            <div class="product-show__value">¥{{ number_format($product->price) }}</div>
        </div>

        <!-- 在庫数 -->
        <div class="product-show__item">
            <label class="product-common__label ">在庫数</label>
            <div class="product-show__value">{{ $product->stock }}</div>
        </div>

        <!-- コメント -->
        <div class="product-show__item">
            <label class="product-common__label ">コメント</label>
            <textarea class="product-show__textarea" readonly>{{ $product->comment }}</textarea>
        </div>

        <!-- ボタン部分 -->
        <div class="product-common__button-wrapper">
            <a href="{{ route('products.edit', $product->id) }}" class="button product-common__button--register--update--edit ">編集</a>
            <a href="{{ route('products.index') }}" class="button product-common__button--back">戻る</a>
        </div>
    </div>
</div>
@endsection