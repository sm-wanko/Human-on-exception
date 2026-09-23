# タスクCRUD画面（UI仕様）

Screen ID: TASK_CRUD

**関連ドキュメント**: [Flow](../flow/タスクCRUD.md) | [Validation](../validation/タスクCRUD.md) | [DB](../db/タスクCRUD.md)

## Scope（対象範囲）

- Task list
- Task detail
- mutation UI はサンプル対象外（API のみ）

## 対象画面

- **一覧**: Task list
- **詳細**: Task detail

## 使用API

- `GET /api/tasks`
- `GET /api/tasks/{id}`

## 画面コンポーネント

- `TaskListPagePresentation`
- `TaskList`
- `TaskDetailPagePresentation`

## 画面の構成

### 一覧

- loading
- empty
- error
- TaskQuick title list

### 詳細

- loading
- error
- title
- description（null は No description）

## UIイベント

### Task 選択

- **クリック時**: 選択 task id で detail へ

## エラー表示（UI）

- request failure は alert
