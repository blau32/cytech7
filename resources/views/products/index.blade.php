@extends('layouts.app')
<!-- layouts.app.blade.phpの@yield('content') -->
@section('content')
<div class="main-container">
    <h1 class="product-common__title">商品一覧画面</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="product-index__form">
        <input
            type="search"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="検索キーワード"
            class="product-index__form-input">

        <select
            name="company_id"
            class="product-index__form-select">
            <option value="">メーカー名</option>
            @foreach ($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
            </option>
            @endforeach
        </select>

        <button type="submit" class="product-index__form-button">
            検索
        </button>
    </form>

    <!-- 一覧テーブル -->
    <table class="product-index__table">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>
                    <a href="{{ route('products.create') }}" class="product-index__button product-index__button--register">
                        新規登録
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product) <!-- テーブルから取り出すイメージ  -->
            <tr class="{{ $loop->odd ? 'row-odd' : 'row-even' }}">
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->img_path)
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="50">
                    @else
                    画像なし
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>¥{{ number_format($product->price) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name ?? '' }}</td>
                <td style="white-space: nowrap;">
                    <a href="{{ route('products.show', $product->id) }}"
                        class="product-index__button product-index__button--detail">
                        詳細
                    </a>

                    <form
                        action="{{ route('products.destroy', $product->id) }}"
                        method="POST"
                        onsubmit="return confirm('本当に削除しますか？')"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="product-index__button product-index__button--delete">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="product-index__pagination">
        {{ $products->links() }}
    </div>
</div>
@endsection