<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductResetSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約を一時的に無効化（安全対策）
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // 全削除（TRUNCATEではなくDELETE）
        DB::table('products')->delete();

        // AUTO_INCREMENTをリセット
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');

        // 外部キー制約を元に戻す
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
