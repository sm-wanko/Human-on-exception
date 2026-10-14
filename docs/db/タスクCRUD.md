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

## SQL / Query 例

各 request は 1 文。ロックや版チェックは無い。

### 一覧

```sql
SELECT id, title
FROM tasks
ORDER BY id;
```

### 詳細

```sql
SELECT *
FROM tasks
WHERE id = ?
LIMIT 1;
```

### 作成

```sql
INSERT INTO tasks (title, description, created_at, updated_at)
VALUES (?, ?, ?, ?)
RETURNING id;
```

### 更新

対象が無いときは 0 行。あるときは次の 1 文のあと、詳細と同じ `SELECT` で読み戻す。

```sql
UPDATE tasks
SET title = ?, description = ?, updated_at = ?
WHERE id = ?;
```

### 削除

```sql
DELETE FROM tasks
WHERE id = ?;
```

## DB 非関与エンドポイント（N/A）

該当なし。Scope 内 API は tasks を read/write する。

## 監査

認証済み会員 mutation 自体が Scope 外のため `created_by` 等の会員監査は N/A。
