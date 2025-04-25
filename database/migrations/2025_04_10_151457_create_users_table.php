
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ユーザーID
            $table->string('username'); //
            $table->string('email')->unique(); // メールアドレス（重複不可）
            $table->timestamp('email_verified_at')->nullable(); // メール認証
            $table->string('password'); // パスワード
            $table->rememberToken(); // ログイン状態をブラウザに保存するためのトークン
            $table->timestamps(); // created_at, updated_at 自動生成
            // ※コード規約と合わないが...？
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};