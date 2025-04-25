<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 論理削除用

class Product extends Model

{
    //トレイト継承(companyモデルから)
    use HasFactory, SoftDeletes;

    //プロパティ定義
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    //リレーション定義
    public function company()
    {
        return $this->belongsTo(Company::class);
        // Product（商品）が、どのCompany（メーカー）に属しているかを表現するリレーション設定
    }

    //データ取得系
    public static function ProductData(\Illuminate\Http\Request $request, int $perPage = 5)
    {
        // 商品一覧取得準備
        $query = self::query();

        // 商品名で部分一致検索を実行（Bladeフォームでキーワードが指定されている場合）
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
            //filled():リクエストに指定された名前の値が空でない 場合に true を返す。
        }

        // メーカーIDで完全一致検索を実行（指定されている場合）
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // ビューに渡す
        return $query->paginate($perPage);
    }

    //詳細情報
    public static function ShowProductData($id)
    {
        $product = self::findOrFail($id);
        return compact('product');
    }

    //編集
    public static function EditProductData($id)
    {
        // IDに対応する商品をデータベースから取り出す
        $product = self::findOrFail($id);

        // 全メーカー情報をデータベースから取り出す
        $companies = \App\Models\Company::all();

        // 画面に渡す変数（productとcompanies）をセットで返す
        return compact('product', 'companies');
    }

    //
    public static function GetCompanyData()
    {
        // メーカー一覧を取得して渡す
        return \App\Models\Company::all();
    }

    // 登録更新系
    //商品登録処理
    public static function RegisterDate(\Illuminate\Http\Request $request)
    {
        // バリデーション（入力チェック）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|integer|exists:companies,id',
            'price'        => 'required|integer|min:0|max:999999999',
            'stock'        => 'required|integer|min:0|max:999999999',
            'comment'      => 'nullable|string|max:1000',
            'img_path'     => 'nullable|image|max:2048',
        ]);

        // 画像の保存処理
        $path = null;
        if ($request->hasFile('img_path')) { //hasFile()：画像ファイルがアップロードされているかを確認
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
        return redirect()->route('products.index')->with('success', '商品を登録しました'); //with()セッションに一時的なメッセージを渡す
    }

    // データ削除
    public static function DeleteProductData($id)
    {
        $product = self::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public static function UpdateProductData(\Illuminate\Http\Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|integer|exists:companies,id',
            'price'        => 'required|integer|min:0|max:999999999',
            'stock'        => 'required|integer|min:0|max:999999999',
            'comment'      => 'nullable|string|max:1000',
            'img_path'     => 'nullable|image|max:2048',
        ]);

        // 画像処理
        $path = null;
        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('images', 'public');
        }

        // 該当商品取得
        $product = self::findOrFail($id);

        // データ更新
        $product->update([
            'product_name' => $request->product_name,
            'company_id'   => $request->company_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'img_path'     => $path ?? $product->img_path, // 新しい画像がなければそのまま
        ]);

        // リダイレクト
        return redirect()->route('products.index')->with('success', '商品を更新しました');
        // ->with('キー名', '値') リダイレクト先に一時的なメッセージ（セッション）を渡す

    }
}
