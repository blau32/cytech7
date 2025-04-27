<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index(Request $request)
    {
        $products = Product::search($request); //DBに対して特定の条件に合うデータのみを取り出す
        $companies = Company::all();
        return view('products.index', compact('products', 'companies'));
    }

    // 商品新規登録画面
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    // 商品登録処理
    public function store(Request $request)
    {
        Product::register($request);
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    // 商品詳細表示
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 商品編集画面
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    // 商品更新処理
    public function update(Request $request, $id)
    {
        Product::updateData($request, $id);
        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    // 商品削除処理
    public function destroy($id)
    {
        Product::deleteData($id);
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
