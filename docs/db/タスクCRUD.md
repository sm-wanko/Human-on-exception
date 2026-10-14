# タスクCRUD（DB・テーブル・SQL）

DB ID: EXAMPLE_TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [UI](../ui/タスクCRUD.md) | [Validation](../validation/タスクCRUD.md)

## Scope（対象範囲）

- tasks table read/write

## 使用テーブル

- `tasks`

## DB Write Order

1. create: `tasks` へ 1 回の INSERT
2. update: 存在確認の SELECT。行が無ければ終了。行があるとき、値が変わった場合だけ UPDATE し、その後に読み戻す
3. delete: `tasks` へ 1 回の DELETE

create と delete は 1 文。update は下の 3 段。

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

ロックや版チェックは無い。

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

1. 分岐を決める存在確認。行が無ければここで終わり、UPDATE は走らない。

```sql
SELECT *
FROM tasks
WHERE id = ?
LIMIT 1;
```

2. `title` と `description` が既存行と違うときだけ更新する。同じ値のときは、この UPDATE は走らない。

```sql
UPDATE tasks
SET title = ?, description = ?, updated_at = ?
WHERE id = ?;
```

3. 行があったときは、UPDATE の有無にかかわらず読み戻す。

```sql
SELECT *
FROM tasks
WHERE id = ?
LIMIT 1;
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
