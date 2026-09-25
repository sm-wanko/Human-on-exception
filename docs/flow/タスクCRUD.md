# タスクCRUDフロー

---

Flow ID: TASK_CRUD

**関連ドキュメント**: [UI（画面仕様）](../ui/タスクCRUD.md) | [Validation（バリデーション）](../validation/タスクCRUD.md) | [DB（テーブル・SQL）](../db/タスクCRUD.md)

## Scope（対象範囲）

- ログインした本人の Task 一覧・詳細・作成・更新・論理削除
- list は TaskQuick、detail は TaskDetail
- 他人の Task と持ち主の無い行は出さない
- 復元画面と物理削除は対象外

## Actor

- **User**: ログインしている本人
- **Client**: TypeScript Frontend
- **Server**: Laravel Controller / Service / Repository

## Entry Point

- **API**: `GET /api/tasks`, `GET /api/tasks/{id}`, `POST /api/tasks`, `PATCH /api/tasks/{id}`, `DELETE /api/tasks/{id}`
- **画面**: Task list / detail / 登録 / 編集

## Normal Flow

### 一覧

1. **Client** `GET /api/tasks`
2. **Controller** ログイン中の利用者 ID を Service へ渡す
3. **Service** Repository の Quick query を呼ぶ
4. **Repository** 本人の、論理削除されていない `id,title,status,due_on` を取得
5. **Server** TaskQuick 一覧を返す

### 詳細

1. **Client** `GET /api/tasks/{id}`
2. **Service** 本人の Detail query
3. **Server** TaskDetail を返す。他人と不存在は同じ 404

### mutation

1. **Client** POST/PATCH/DELETE
2. **FormRequest** validation
3. **Controller → Service → Repository**。監査値は操作者
4. **DB write**
5. **response**

作成直後の STATUS は `not_started`（未着手）。チェックの DELETE は行を残し、STATUS は変えない。終了予定日が過去でも STATUS は変わらない。

## DB Write

- create: tasks insert。持ち主と監査を入れる
- update: tasks update
- delete: `deleted_at` を入れる論理削除

## Response

- create: 201
- read/update: 200
- delete: 204

## Error Flow

- 401: 未ログイン。書き込みなし
- 422: validation
- 404: 本人のものでない id、不存在、論理削除済み
- 500: unexpected internal error

## ログ出力

- framework error log。サンプル固有の成功ログなし。

## テストマトリクス（System Integration Test）

Flow ID: TASK_CRUD

### 正系

| ID | 操作 | 入力 | 期待 response | 期待 DB 状態 | 備考 |
|---|---|---|---|---|---|
| TASK_CRUD-SYS-001 | create → list | title / description | 201 → 200 | row 1 件。status `not_started`。created_by は本人 | list は Quick |
| TASK_CRUD-SYS-002 | detail | id | 200 | 変更なし | description を含む |
| TASK_CRUD-SYS-003 | update | title / status | 200 | title と status 更新 | |
| TASK_CRUD-SYS-004 | logical delete | id | 204 | 行は残り `deleted_at`。一覧と詳細から消える | 物理削除しない |
| TASK_CRUD-SYS-008 | create | 過去の due_on と偽の created_at | 201 | status は `not_started`。登録日はサーバー時刻 | 日付は STATUS を変えない |
| TASK_CRUD-SYS-009 | logical delete | status `in_progress` | 204 | status は `in_progress` のまま | チェックは完了ではない |
| TASK_CRUD-SYS-010 | create → update → logical delete | title | 201 → 200 → 204 | created_by / updated_by は本人、app は `member-ui` | 監査 |

### 逆系

| ID | 操作 | 期待 response | 期待 DB | 備考 |
|---|---|---|---|---|
| TASK_CRUD-SYS-005 | 未ログインの read / write | 401 | write なし | |
| TASK_CRUD-SYS-006 | 他人の id と不存在 | 404 | 他人の行は不変 | 403 にしない |
| TASK_CRUD-SYS-007 | 持ち主の無い行 | 一覧に出ない。detail 404 | 行は残る | 削除しない |
| TASK_CRUD-SYS-101 | blank title create | 422 | write なし | |
| TASK_CRUD-SYS-102 | unknown id detail | 404 | write なし | ログイン済み |

## Frontend 契約

| ID | 操作 | 入力・前提 | 期待 | 備考 |
|---|---|---|---|---|
| TASK_CRUD-FE-001 | list 初期 | loading | loading 表示 | contract |
| TASK_CRUD-FE-002 | list 0件 | [] | empty 表示 | contract |
| TASK_CRUD-FE-003 | list error | API error | error 表示 | contract |
| TASK_CRUD-FE-004 | task 選択 | id=42 | detail id=42 | contract |
| TASK_CRUD-FE-005 | 登録 | 内容のみ | 詳細と終了予定日は空 | contract |
| TASK_CRUD-FE-006 | 編集 | status done / 終了予定日 | 保存値 done。表示は完了。登録日は Asia/Tokyo | contract |
| TASK_CRUD-FE-007 | チェック | id | 一覧から外れる | contract |

### SIT スコープ外（N/A）

- 復元画面: この契約では作らない。
- 終了予定日を過ぎたことによる自動の STATUS 変更: 持たない。
