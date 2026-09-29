# タスクCRUD画面（UI仕様）

Screen ID: TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [Validation](../validation/タスクCRUD.md) | [DB](../db/タスクCRUD.md)

## Scope（対象範囲）

- Task list
- Task detail
- 登録と編集
- チェックによる論理削除。完了 STATUS とは別

## 対象画面

- **一覧**: Task list
- **詳細**: Task detail
- **登録**: `/tasks/new/`
- **編集**: `/tasks/[id]/edit/`

## 使用API

- `GET /api/tasks`
- `GET /api/tasks/{id}`
- `POST /api/tasks`
- `PATCH /api/tasks/{id}`
- `DELETE /api/tasks/{id}`

## 画面コンポーネント

- `TaskListPagePresentation`
- `TaskList`
- `TaskDetailPagePresentation`
- `TaskFormPresentation`

## 画面の構成

### 一覧

- loading
- empty
- error
- 内容、STATUS の表示、終了予定日
- 一覧から外すチェック

### 詳細

- loading
- error
- 内容
- 詳細（null は No description）
- 登録日。編集できない
- 終了予定日
- STATUS の表示

### 登録 / 編集

- 内容、詳細、STATUS、終了予定日
- 編集のときだけ登録日を表示する。入力欄にはしない

## UIイベント

### Task 選択

- **クリック時**: 選択 task id で detail へ

### チェック

- **オン**: DELETE。その行を一覧から外す。STATUS のラベルは変えない

## エラー表示（UI）

- request failure は alert

## STATUS 表示

| 保存値 | 表示 |
|---|---|
| `not_started` | 未着手 |
| `in_progress` | 進行中 |
| `done` | 完了 |
