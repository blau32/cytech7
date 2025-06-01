## 🔀 ブランチ情報（2025/6/1）

---

### `main`（現在の作業基準ブランチ）
- **目的**：MySQLの物理ファイル破損（`.ibd` desync）後の復旧対応
- **内容**：
  - `companies`, `products`, `sales` テーブルの復旧（DISC → IMPORT）
  - `.gitignore` に `.ibd`, `ibdata1` を除外設定
  - LaravelルートやModelの調整あり
- **備考**：
  - **今後のすべての作業はこのブランチを基準に行うこと**

---

### `master`（安定版・提出用）
- Laravel初期構成（復旧前）
- コードレビューや比較用のスナップショット
- **直接コミットはしない**

---

### `non_resource_routes`
- `Route::resource` を使わない構成に切り分けたブランチ
- ルートの書き方を手動で記述したパターン

---

### `refactor_resource`
- `master` のバックアップ的ブランチ
- ブレークポイントが分からなくなったとき用の保険
