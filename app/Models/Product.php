<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
        // 商品テーブルから会社テーブルを参照する
    }

    // 商品一覧検索
    public static function search(Request $request, int $perPage = 5)
    {
        $query = self::query();
        //自身のproductクラスのカラムを代入

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
            // 検索フォームに入力された値を検索条件にする
            //product_name LIKE "%キーワード%"で検索
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        return $query->paginate($perPage);
    }

    // 商品登録
    public static function register(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|integer|exists:companies,id',
            'price'        => 'required|integer|min:0|max:999999999',
            'stock'        => 'required|integer|min:0|max:999999999',
            'comment'      => 'nullable|string|max:1000',
            'img_path'     => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('img_path')) {
            $filename = uniqid() . '.' . $request->file('img_path')->getClientOriginalExtension();
            $path = $request->file('img_path')->storeAs('images', $filename, 'public');
        }
        //hasFile()メソッドは、ファイルの存在を確認するメソッド
        //uniqid()メソッドは、一意な文字列を生成するメソッド
        //getClientOriginalExtension()メソッドは、ファイルの拡張子を取得するメソッド
        //storeAs()メソッドは、ファイルを保存するメソッド

        self::create(array_merge($validated, ['img_path' => $path]));
        //array_merge()メソッドは、配列を結合するメソッド
        //($validated, ['img_path' => $path]) は、$validated配列と['img_path' => $path]配列を結合する
        //['img_path' => $path] は、ファイルのパスを格納する
    }

    // 商品更新
    public static function updateData(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|integer|exists:companies,id',
            'price'        => 'required|integer|min:0|max:999999999',
            'stock'        => 'required|integer|min:0|max:999999999',
            'comment'      => 'nullable|string|max:1000',
            'img_path'     => 'nullable|image|max:2048',
        ]);

        $product = self::findOrFail($id);

        $path = $product->img_path;
        if ($request->hasFile('img_path')) {
            $filename = uniqid() . '.' . $request->file('img_path')->getClientOriginalExtension();
            $path = $request->file('img_path')->storeAs('images', $filename, 'public');
        }


        $product->update(array_merge($validated, ['img_path' => $path]));
    }

    // 商品削除
    public static function deleteData($id)
    {
        $product = self::findOrFail($id);
        $product->delete();
    }

}
