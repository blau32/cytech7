@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報詳細画面</h1>

    <div class="product_form-wrapper">
        <div class="product_form-item">
            <label>ID</label>
            <div class="product_item-info">{{ $product->id }}.</div>
        </div>

        <div class="product_form-item">
            <label for="img_path">商品画像</label>
            <div>
                @if ($product->img_path)
                <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="150">
                @else
                <span class="product_item-info">画像なし</span>
                @endif
            </div>
        </div>

        <div class="product_form-item">
            <label for="product_name">商品名</label>
            <div class="product_item-info">{{ $product->product_name }}</div>
        </div>

        <div class="product_form-item">
            <label for="company_id">メーカー名</label>
            <div class="product_item-info">{{ $product->company->company_name ?? '不明' }}</div>
        </div>

        <div class="product_form-item">
            <label for="price">価格</label>
            <div class="product_item-info">¥{{ number_format($product->price) }}</div>
        </div>

        <div class="product_form-item">
            <label for="stock">在庫数</label>
            <div class="product_item-info">{{ $product->stock }}</div>
        </div>

        <div class="product_form-item">
            <label for="comment">コメント</label>
            <textarea readonly class="product_detail-comment">{{ $product->comment }}</textarea>
        </div>

        <!-- ボタンエリア -->
        <div class="product_form-buttons">
            <a href="{{ route('products.edit', ['product' => $product->id]) }}">
                <button type="button" class="common-button product_form-submitbutton">編集</button>
            </a>

            <a href="{{ route('products.index') }}">
                <button type="button" class="common-button product_form-backbutton">戻る</button>
            </a>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('js/autoResize.js') }}"></script>