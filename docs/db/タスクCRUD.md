# タスクCRUD（DB・テーブル・SQL）

DB ID: EXAMPLE_TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [UI](../ui/タスクCRUD.md) | [Validation](../validation/タスクCRUD.md)

## Scope（対象範囲）

- tasks table read/write

## 使用テーブル

- `tasks`

## DB Write Order

1. create: tasks INSERT
2. update: tasks UPDATE
3. delete: tasks DELETE

各 request は単一 table write。

## テーブル登録項目

### tasks

| カラム | 値 | 備考 |
|--------|-----|------|
| id | auto | PK |
| title | string(200) | not null |
| description | text | nullable |
| created_at | timestamp | Laravel |
| updated_at | timestamp | Laravel |

## Query

- list Quick: `id,title` のみ
- detail: `id,title,description,created_at,updated_at`

## DB 非関与エンドポイント（N/A）

該当なし。Scope 内 API は tasks を read/write する。

## 監査

認証済み会員 mutation 自体が Scope 外のため `created_by` 等の会員監査は N/A。
