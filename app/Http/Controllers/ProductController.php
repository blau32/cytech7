<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company; // 追加（会社情報用）
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ファイル保存用

class ProductController extends Controller
{
    /**
     * 商品一覧画面
     */
    public function index(Request $request)
    // ブラウザから送られてきた情報（リクエスト）を $request という変数に入れる。
    // ブラウザから送られたフォームデータ（検索キーワードや会社ID）を受け取るため。
    // Requestを受け取らないと、ユーザーが何を入力したかがわからない。


    {
        // 商品一覧のクエリ
        $query = Product::query();

        // 商品名検索（部分一致）
        if ($request->filled('keyword')) { //キーワードが入力されていた場合
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
            //部分一致検索
            //where() :データベースのデータを、条件に合うものだけに絞り込む
            //where(列名, 演算子, 比較する値)
            //like:部分一致:SELECT * FROM products WHERE product_name LIKE '%product_name%'と同じ
            //'%' → SQLで「何文字でもいい」という意味のワイルドカード
        }

        // メーカー検索（完全一致）
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // 1ページに5件ずつ取得 暫定
        $products = $query->paginate(5);

        // メーカー一覧も取得
        $companies = Company::all();

        // ビューに渡す
        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品登録処理
     */
    public function store(Request $request)
    {
        // バリデーション（入力チェック）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048', // 画像ファイルのみ、最大2MB
        ]);

        // 画像の保存処理
        $path = null;
        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('images', 'public');
        }

        // 商品データの登録
        Product::create([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $path,
        ]);

        // 登録後、商品一覧画面へリダイレクト
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function create()
    {
        // メーカー一覧を取得して渡す
        $companies = \App\Models\Company::all();

        return view('products.create', compact('companies'));
    }

    public function edit($id)
    {
        // 編集対象の商品をデータベースから取得
        $product = \App\Models\Product::findOrFail($id);

        // メーカー一覧も取得（セレクトボックス用）
        $companies = \App\Models\Company::all();

        // 編集画面を表示
        return view('products.edit', compact('product', 'companies'));
    }

    //商品削除
    public function destroy($id){
        // 削除対象の商品を取得
        $product = \App\Models\Product::findOrFail($id); //findOrFail($id)	IDで商品を取得。なければ404エラー

        // 商品を削除
        $product->delete();

        // 削除後、商品一覧にリダイレクト
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public function show($id){
        // 指定されたIDの商品データを取得
        $product = Product::findOrFail($id);

        // 商品に紐づく会社名を取得する場合（オプション）
        $company = $product->company;

        // ビューに渡す
        return view('products.show', compact('product', 'company'));
    }

    public function update(Request $request, $id)
    {
        // ★まずバリデーションを実施
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像ファイルのバリデーション
        ]);

        // ★対象の商品データを取得
        $product = Product::findOrFail($id);

         // データ更新
        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;

        // ★画像がアップロードされた場合のみ処理
        if  ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('images', 'public');  // storage/app/public/imagesに保存
            $product->img_path = $path; // DBにパス保存
        }

        $product->save(); // 最後に保存

        // 一覧に戻る
        return redirect()->route('products.index')->with('success', '商品情報を更新しました');
    }
}