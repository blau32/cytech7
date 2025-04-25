<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //商品一覧画面
    public function index(Request $request)
    {
        $products = Product::ProductData($request);
        $companies = Company::all();
        return view('products.index', compact('products', 'companies'));
    }

    //商品登録画面
    public function create()
    {
        $companies = Product::GetCompanyData();
        return view('products.create', compact('companies'));
    }

    //商品登録処理
    public function store(Request $request)
    {
        return Product::RegisterDate($request);
    }

    // 商品詳細画面（show）
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 商品編集画面（edit）
    public function edit($id)
    {
        // 編集画面を表示
        return view('products.edit', Product::EditProductData($id));
    }

    // 商品更新処理（update）
    public function update(Request $request, $id)
    {
        return Product::UpdateProductData($request, $id);
    }

    // 商品削除処理（destroy）
    public function destroy($id)
    {
        return Product::DeleteProductData($id);
    }






}
