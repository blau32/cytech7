<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // 商品ID（自動採番）
            $table->unsignedBigInteger('company_id'); // 外部キー（メーカーID）
            $table->string('product_name'); // 商品名
            $table->integer('price'); // 価格
            $table->integer('stock'); // 在庫数
            $table->text('comment')->nullable(); // コメント（nullable）
            $table->string('img_path')->nullable(); // 画像パス（nullable）
            $table->softDeletes(); // 削除フラグ
            $table->timestamps();  // ※コード規約と合わないが...？
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
