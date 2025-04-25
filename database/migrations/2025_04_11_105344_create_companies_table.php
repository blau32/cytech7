<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id'); // メーカーID
            $table->string('company_name'); // メーカー名
            $table->string('street_address'); //住所
            $table->string('representative_name'); //代表者
            $table->timestamps();  // ※コード規約と合わないが...？
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
