@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="index_form">
        <input type="search" name="keyword" value="{{ request('keyword') }}" placeholder="検索キーワード" class="index_search_form">

        <select name="company_id" class="index_select_form">
            <option value="">メーカー名</option>
            @foreach ($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
            </option>
            @endforeach
        </select>

        <button type="submit" class="index_search_button">検索</button>
    </form>

    <!-- 商品一覧テーブル -->
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>
                    <a href="{{ route('products.create') }}">
                        <button type="button" class="common-button index_create_button">新規登録</button>
                    </a>
                </th> <!-- テーブルカラム内に新規登録ボタン -->
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
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

                <td>
                    <!-- 詳細ボタン -->
                    <a href="{{ route('products.show', $product->id) }}">
                        <button type="button" class="common-button index_detail_button">詳細</button>
                    </a>

                    <!-- 削除ボタン -->
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="common-button index_delete_button">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Bladeのページネーション表示-->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
