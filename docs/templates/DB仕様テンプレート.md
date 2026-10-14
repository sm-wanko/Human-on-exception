# {{機能名}}（DB・テーブル・SQL）

DB ID: {{ID}}

**関連ドキュメント**: [Flow](../flow/{{機能名}}.md) | [UI](../ui/{{機能名}}.md) | [Validation](../validation/{{機能名}}.md)

## Scope（対象範囲）

- （対象処理 / table）

## 使用テーブル

- （table）

## DB Write Order

1. （write）

## テーブル登録項目

### 1. （table）

| カラム | 値 | 備考 |
|--------|-----|------|
| | | |

## SQL / Query 例

ソースファイルへのパスでは、この節を満たさない。各 write と、分岐・ロック・競合・版を決める read を文で書く。`WHERE`、`ON CONFLICT`、`FOR UPDATE` は文の中に置く。プレースホルダはこのリポジトリの `?` または `$1` を使う。

### 参照

```sql
SELECT id, title
FROM example_table
WHERE owner_id = ?
ORDER BY id;
```

### 作成（1 トランザクション）

```sql
INSERT INTO example_table (title, created_at, updated_at)
VALUES (?, ?, ?)
RETURNING id;
```

### 更新（条件に合う行だけ）

```sql
UPDATE example_table
SET title = ?, updated_at = ?
WHERE id = ? AND version = ?;
```

## DB 非関与エンドポイント（N/A）

- （該当時）
