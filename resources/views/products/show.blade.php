@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報詳細画面</h1>

    <div class="product-detail-wrapper">
        <div class="product-detail__item">
            <label>ID</label>
            <div>{{ $product->id }}</div>
        </div>

        <div class="product-detail__item">
            <label>商品画像</label>
            <div>
                @if ($product->img_path)
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="150">
                @else
                    画像なし
                @endif
            </div>
        </div>

        <div class="product-detail__item">
            <label>商品名</label>
            <div>{{ $product->product_name }}</div>
        </div>

        <div class="product-detail__item">
            <label>メーカー名</label>
            <div>{{ $product->company->company_name ?? '不明' }}</div>
        </div>

        <div class="product-detail__item">
            <label>価格</label>
            <div>¥{{ number_format($product->price) }}</div>
        </div>

        <div class="product-detail__item">
            <label>在庫数</label>
            <div>{{ $product->stock }}</div>
        </div>

        <div class="product-detail__item">
            <label>コメント</label>
            <textarea readonly class="product-detail__comment">{{ $product->comment }}</textarea>
        </div>

        <!-- ボタンエリア -->
        <div class="product-detail__buttons">
            <a href="{{ route('products.edit', ['product' => $product->id]) }}">
                <button type="button" class="product-detail__edit-button">編集</button>
            </a>

            <a href="{{ route('products.index') }}">
                <button type="button" class="product-detail__back-button">戻る</button>
            </a>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('js/autoResize.js') }}"></script>
