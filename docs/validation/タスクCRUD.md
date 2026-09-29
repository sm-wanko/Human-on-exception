# タスクCRUD（バリデーション・エラーハンドリング）

Validation ID: TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [UI](../ui/タスクCRUD.md) | [DB](../db/タスクCRUD.md)

## Scope（対象範囲）

- ログイン済みの POST / PATCH `/api/tasks`
- path id / not found
- 未ログインは 401

## 対象API

- `POST /api/tasks`
- `PATCH /api/tasks/{id}`
- `GET /api/tasks/{id}`
- `DELETE /api/tasks/{id}`
- `GET /api/tasks`

## Validation カテゴリ

### 必須チェック (required)

- `title`
- `status` を送るときは必須

### 文字数チェック (length)

- `title`: trim 後 1〜200
- `description`: nullable / max 2000。空白だけは null

### 値チェック

- `status`: `not_started` / `in_progress` / `done`。省略した作成は `not_started`
- `due_on`: `Y-m-d` または空。過去でも STATUS は変えない
- `created_at` は入力として使わない

## サーバーサイドバリデーション

Laravel FormRequest で実施。`authorize` はログイン済みだけ真。

## エラーハンドリング（HTTP）

### 401

- 未ログインの閲覧と書き込み。DB は変わらない

### 422

- title blank / too long
- description too long
- status が許可値でない
- due_on の形式不正

### 404

- 本人の有効な Task でない id。他人、不存在、論理削除済みを分けない

### 500

- unexpected internal error

## バリデーション非適用エンドポイント（N/A）

| method | path | 振る舞い | 実装ファイル |
|---|---|---|---|
| GET | `/api/tasks` | client input なし。ログインは必須 | `apps/backend/app/Http/Controllers/TaskController.php` |
| GET | `/api/tasks/{task}` | path id 以外の client input なし | `apps/backend/app/Http/Controllers/TaskController.php` |
| DELETE | `/api/tasks/{task}` | body なし。論理削除 | `apps/backend/app/Http/Controllers/TaskController.php` |
