<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← 追加（論理削除用）

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 保存を許可するカラム
     * $fillable：create()などで許可するカラムを指定する
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
    }

}
