# タスクCRUD（バリデーション・エラーハンドリング）

Validation ID: TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [UI](../ui/タスクCRUD.md) | [DB](../db/タスクCRUD.md)

## Scope（対象範囲）

- POST /api/tasks
- PATCH /api/tasks/{id}
- path id / not found
- 認証は対象外

## 対象API

- `POST /api/tasks`
- `PATCH /api/tasks/{id}`
- `GET /api/tasks/{id}`
- `DELETE /api/tasks/{id}`

## Validation カテゴリ

### 必須チェック (required)

- `title`

### 文字数チェック (length)

- `title`: trim 後 1〜200
- `description`: nullable / max 2000

## サーバーサイドバリデーション

Laravel FormRequest で実施。

## エラーハンドリング（HTTP）

### 422

- title blank / too long
- description too long

### 404

- id が存在しない

### 500

- unexpected internal error

## バリデーション非適用エンドポイント（N/A）

| method | path | 振る舞い | 実装ファイル |
|---|---|---|---|
| GET | `/api/tasks` | client input なし | `apps/backend/app/Http/Controllers/TaskController.php` |

認証・認可は本 Flow では N/A。
