# Pack: task-crud

Task CRUD の 1 束。Flow ID: `EXAMPLE_EXAMPLE_TASK_CRUD`。

意味の入口: [Task CRUD の概念](../../concept/task-crud.md)。既存制約と人間判断の教材: [Questions](../../testing/questions/task-crud.md)。

## 束の境界（docs）

| 含む | 含まない（別束） |
|------|------------------|
| Task list / detail | 認証 |
| Task create / update / delete API | 会員監査 |
| Quick / Detail read model | soft delete / audit history |
| EXAMPLE_EXAMPLE_TASK_CRUD SYS / FE | 他ドメイン |

## 4 点セット

| 観点 | doc |
|------|-----|
| flow | [タスクCRUD.md](../../flow/タスクCRUD.md) |
| ui | [ui/タスクCRUD.md](../../ui/タスクCRUD.md) |
| validation | [validation/タスクCRUD.md](../../validation/タスクCRUD.md) |
| db | [db/タスクCRUD.md](../../db/タスクCRUD.md) |

## 束完了チェックリスト

**テスト Gap A = 0 のみでは Done にしない。**

### ドキュメント

- [x] 4 点セット存在
- [x] flow Scope
- [x] FE / SYS マトリクス

### pack

- [x] 本ファイル

### Frontend

- [x] `EXAMPLE_EXAMPLE_TASK_CRUD-FE-001`〜`004`
- [x] list / detail Presentation
- [x] lib resolver / viewmodel

### Backend（SIT）

- [x] `EXAMPLE_EXAMPLE_TASK_CRUD-SYS-001`〜`004`
- [x] `EXAMPLE_EXAMPLE_TASK_CRUD-SYS-101`〜`102`

## Frontend（実装パス）

| ファイル | 役割 |
|----------|------|
| `apps/frontend/src/api/task.ts` | API |
| `apps/frontend/src/lib/task/` | 表示意味 / resolver |
| `apps/frontend/src/hooks/task/` | state / side effect |
| `apps/frontend/src/features/task/` | Presentation |

## Backend（実装パス）

| ファイル | 役割 |
|----------|------|
| `apps/backend/app/Http/Controllers/TaskController.php` | HTTP |
| `apps/backend/app/Services/Task/TaskService.php` | business / orchestration |
| `apps/backend/app/Repositories/Task/TaskRepository.php` | persistence |
| `apps/backend/app/DTO/Task/` | Quick / Detail |
| `apps/backend/tests/System/TaskCrudSystemTest.php` | SYS-ID |

## 完了コマンド

```bash
make lint
make test
make survey
```

## 禁止

- API 形状の無断変更
- Quick / Detail の無断統合
- 認証・soft delete を Scope に追加
