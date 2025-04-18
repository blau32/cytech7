<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← 追加（論理削除用）

class Product extends Model
// DBが必要なファイル？をクラスに指定
{
    //controllerから転記
    public static function ProductData(\Illuminate\Http\Request $request, int $perPage = 5)
    {
        /*
        Request:ユーザーからサーバーへの要求
        つまるところユーザーが何かしらの行動を全てRequestオブジェクトで受け取る
        その受け取った情報を$requestに渡す
        */

        // 商品一覧取得（検索条件に応じて絞り込み）
        $query = self::query();
        //SELECT * FROM products の準備状態。条件検索（WHERE句など）を柔軟に追加できるようになる？
        //検索の準備のみ？

        // 商品名で部分一致検索を実行（キーワードが指定されている場合）
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
            //filled():リクエストに指定された名前の値が空でない 場合に true を返す。
            //like:SQLで「部分一致検索」を行う。
        }

        // メーカーIDで完全一致検索を実行（指定されている場合）
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // ビューに渡す
        return $query->paginate($perPage);
        // compact() 同名の変数を連想配列として渡す
        //商品一覧をひらいたタイミングで処理？
    }

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
        // $path = null; 画像ファイルが存在しないケースを想定
        // hasFile()：画像ファイルがアップロードされているかを確認
        // file('img_path')：アップロードファイルの取得
        // store()：storage/app/public/images/ に保存され、public/storage から公開される

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

    public static function DeleteProductData($id)
    {
        $product = self::findOrFail($id); // 1件取得（見つからなければ404）
        $product->delete();               // 論理削除（SoftDeletesが有効な場合）

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }


    public static function GetCompanyData()
    {
        // メーカー一覧を取得して渡す
        return \App\Models\Company::all();
    }

    public static function ShowProductData($id)
    {
        $product = self::findOrFail($id);
        return compact('product');
    }

    public static function EditProductData($id)
    {
        // IDに対応する商品をデータベースから取り出す
        $product = self::findOrFail($id);

        // 全メーカー情報をデータベースから取り出す
        $companies = \App\Models\Company::all();

        // 画面に渡す変数（productとcompanies）をセットで返す
        return compact('product', 'companies');
    }





    use HasFactory, SoftDeletes;
    /*
    Factory	モデルのテスト用「ダミーデータ」を自動生成する仕組み
    HasFactory	ファクトリを使うための「トレイト」。これを use しないと使えない?
    */

    /**
     * 保存を許可するカラム
     * $fillable：create()などで許可するカラムを指定する
     * $fillable に下記の情報が登録されていなければ保存できない
     */
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
        //	リレーション（外部キー）の定義：1対多の「子」側
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
