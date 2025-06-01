🔀 ブランチ情報（2025/6/1）
master（安定版）
Laravelの初期構成（復旧前の状態）
コードレビュー・提出用の基準ブランチ
基本的に 直接コミットしない
fix/mysql-recovery
目的：MySQLの物理ファイル破損（.ibd desync）後の復旧対応
内容：
companies, products, sales テーブルの復旧（DISC → IMPORT）
.gitignore に .ibd, ibdata1 を除外設定
LaravelルートやModelの調整あり
備考：
今後の作業はこのブランチを基準とする
non_resource_routes
Route::resource...を使用しないversion
refactor_resource
masterの保険だった
