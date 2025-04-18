<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company; // 追加（会社情報用）
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ファイル保存用


//route->controller->modelの順で呼び出す
// Models/Productに処理内容記載。ここでは処理の呼び出しを行う
class ProductController extends Controller
{
    //商品一覧画面
    public function index(Request $request)
    {
        $products = Product::ProductData($request);
        $companies = Company::all();
        return view('products.index', compact('products', 'companies'));
    }


    //商品登録処理
    public function store(Request $request)
    {
        return Product::RegisterDate($request);
    }


    public function create()
    {
        $companies = Product::GetCompanyData();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品削除
     */
    public function destroy($id)
    {
        return Product::DeleteProductData($id);
    }


    public function show($id)
    {
        // ビューに渡す
        return view('products.show', compact('product', 'company'));
    }

    public function edit($id)
    {
        // 編集画面を表示
        return view('products.edit', Product::EditProductData($id));
    }

    public function update(Request $request, $id)
    {
        return Product::UpdateProductData($request, $id);
    }

}
