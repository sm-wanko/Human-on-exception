# タスクCRUDフロー

---

Flow ID: EXAMPLE_TASK_CRUD

**関連ドキュメント**: [UI（画面仕様）](../ui/タスクCRUD.md) | [Validation（バリデーション）](../validation/タスクCRUD.md) | [DB（テーブル・SQL）](../db/タスクCRUD.md)

## Scope（対象範囲）

- Task 一覧・詳細・作成・更新・削除
- list は TaskQuick、detail は TaskDetail
- 認証は対象外

## Actor

- **User**: Task を閲覧・変更する利用者
- **Client**: TypeScript Frontend
- **Server**: Laravel Controller / Service / Repository

## Entry Point

- **API**: `GET /api/tasks`, `GET /api/tasks/{id}`, `POST /api/tasks`, `PATCH /api/tasks/{id}`, `DELETE /api/tasks/{id}`
- **画面**: Task list / detail

## Normal Flow

### 一覧

1. **Client** `GET /api/tasks`
2. **Controller** Service を呼ぶ
3. **Service** Repository の Quick query を呼ぶ
4. **Repository** `id,title` のみ取得
5. **Server** TaskQuick 一覧を返す

### 詳細

1. **Client** `GET /api/tasks/{id}`
2. **Service** Repository の Detail query
3. **Server** TaskDetail を返す

### mutation

1. **Client** POST/PATCH/DELETE
2. **FormRequest** validation
3. **Controller → Service → Repository**
4. **DB write**
5. **response**

## DB Write

- create: tasks insert
- update: tasks update
- delete: hard delete

## Response

- create: 201
- read/update: 200
- delete: 204

## Error Flow

- 422: validation
- 404: unknown task
- 500: unexpected internal error

## ログ出力

- framework error log。サンプル固有の成功ログなし。

## テストマトリクス（System Integration Test）

Flow ID: EXAMPLE_TASK_CRUD

### 正系

| ID | 操作 | 入力 | 期待 response | 期待 DB 状態 | 備考 |
|---|---|---|---|---|---|
| EXAMPLE_TASK_CRUD-SYS-001 | create → list | title / description | 201 → 200 | row 1 件 | list は Quick |
| EXAMPLE_TASK_CRUD-SYS-002 | detail | id | 200 | 変更なし | description を含む |
| EXAMPLE_TASK_CRUD-SYS-003 | update | title | 200 | title 更新 | |
| EXAMPLE_TASK_CRUD-SYS-004 | delete | id | 204 | row 削除 | hard delete |

### 逆系

| ID | 操作 | 期待 response | 期待 DB | 備考 |
|---|---|---|---|---|
| EXAMPLE_TASK_CRUD-SYS-101 | blank title create | 422 | write なし | |
| EXAMPLE_TASK_CRUD-SYS-102 | unknown id detail | 404 | write なし | |

## Frontend 契約

| ID | 操作 | 入力・前提 | 期待 | 備考 |
|---|---|---|---|---|
| EXAMPLE_TASK_CRUD-FE-001 | list 初期 | loading | loading 表示 | contract |
| EXAMPLE_TASK_CRUD-FE-002 | list 0件 | [] | empty 表示 | contract |
| EXAMPLE_TASK_CRUD-FE-003 | list error | API error | error 表示 | contract |
| EXAMPLE_TASK_CRUD-FE-004 | task 選択 | id=42 | detail id=42 | contract |

### SIT スコープ外（N/A）

- 認証 / 会員監査: サンプル Scope 外。
