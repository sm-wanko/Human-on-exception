# タスクCRUD（DB・テーブル・SQL）

DB ID: TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [UI](../ui/タスクCRUD.md) | [Validation](../validation/タスクCRUD.md)

## Scope（対象範囲）

- ログインした本人の tasks read/write
- 論理削除。物理 DELETE はしない

## 使用テーブル

- `tasks`
- `users`（持ち主）

## DB Write Order

1. create: tasks INSERT
2. update: tasks UPDATE
3. logical delete: `deleted_at` と updated 監査を UPDATE

各 request は単一 table write。

## テーブル登録項目

### tasks

| カラム | 値 | 備考 |
|--------|-----|------|
| id | auto | PK |
| user_id | nullable FK users | 新しい行はログイン中の本人。既存の null は誰にも見せない |
| title | string(200) | 内容。not null |
| description | text | 詳細。nullable |
| status | string(32) | `not_started` / `in_progress` / `done`。既定 `not_started` |
| due_on | date | 終了予定日。nullable |
| deleted_at | timestamp | 論理削除。null が通常の一覧 |
| created_by | bigint | 作成した本人 |
| created_app | string(32) | `member-ui` |
| updated_by | bigint | 更新した本人 |
| updated_app | string(32) | `member-ui` |
| created_at | timestamp | 登録日。入力では上書きしない |
| updated_at | timestamp | Laravel |

## Query

- list Quick: 本人かつ未削除の `id,title,status,due_on`
- detail: 本人かつ未削除

## DB 非関与エンドポイント（N/A）

該当なし。Scope 内 API は tasks を read または write する。

## 監査

会員向けの作成・更新・論理削除は `created_by` / `created_app` / `updated_by` / `updated_app` を書く。持ち主の無い既存行は対象外。
