# タスク CRUD — 着手前 QA（確定）

**Status**: 回答済み  
**正本**: 本ファイルは要件定義の経緯 Archive。現在仕様は code + 4 点セット。  
**Pack**: `task-crud`  
**Flow**: `TASK_CRUD`  
**関連**: [タスクCRUD flow](../../flow/タスクCRUD.md)

---

## サマリ

- **目的**: Laravel + TypeScript の最小 CRUD で、Human → Questions → Answers → Issue → 実装 → docs → PR の形を示す。
- **API**: 一覧 / 詳細 / 作成 / 更新 / 削除。
- **read model**: 一覧は Quick、詳細は Detail。
- **削除**: hard delete。
- **認証**: サンプルでは N/A。

---

## 現状（事実）

| 項目 | 現在 |
|------|------|
| Backend | Laravel Controller → Service → Repository → Eloquent / DTO |
| Frontend | TypeScript。表示判断は `lib/task`、Presentation は `features/task` |
| 一覧 | `TaskQuick` |
| 詳細 | `TaskDetail` |
| Flow | `TASK_CRUD` |
| SIT | `TASK_CRUD-SYS-001`〜 |
| FE | `TASK_CRUD-FE-001`〜 |

---

## 確定事項

| ID | 決定内容 |
|----|----------|
| Q1 | 削除は **hard delete** |
| Q2 | title は trim 後必須・最大 200 文字 |
| Q3 | list は **TaskQuick**、detail は **TaskDetail** |
| Q4 | 認証・会員監査はサンプル Scope 外（N/A） |

---

## Questions — 確定回答

### Q1. 削除単位

| 選択肢 | 内容 |
|--------|------|
| A | hard delete |
| B | soft delete |

**Answer**: A。監査・復元をサンプルの責務に含めない。

### Q2. title 制約

| 選択肢 | 内容 |
|--------|------|
| A | non-empty のみ |
| B | trim 後 1〜200 文字 |

**Answer**: B。Validation / DB 制約を明示できるため。

### Q3. list / detail read model

| 選択肢 | 内容 |
|--------|------|
| A | 1 DTO を共用 |
| B | Quick / Detail を分ける |

**Answer**: B。一覧で detail 専用データを読まない。

### Q4. 認証

| 選択肢 | 内容 |
|--------|------|
| A | 認証を含める |
| B | サンプル Scope 外 |

**Answer**: B。

---

## Issue 分割（起票案）

| 順 | タイトル（案） | Pack / Flow | 依存 |
|----|----------------|-------------|------|
| 1 | `feat: Task CRUD backend` | `task-crud` / `TASK_CRUD` | なし |
| 2 | `feat: Task CRUD frontend list/detail` | `task-crud` / `TASK_CRUD` | 1 |

---

## 完了 `make`

```bash
make lint
make test
make survey
```
