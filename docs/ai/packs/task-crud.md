# Pack: task-crud

Task CRUD の 1 束。Flow ID: `TASK_CRUD`。

意味の入口: [Task CRUD の概念](../../concept/task-crud.md)。既存制約と人間判断の教材: [Questions](../../testing/questions/task-crud.md)。

## 束の境界（docs）

| 含む | 含まない（別束） |
|------|------------------|
| 本人の Task list / detail / 登録 / 編集 | アカウント登録 |
| 論理削除と STATUS | 復元 |
| Quick / Detail read model | 他人の Task |
| TASK_CRUD SYS / FE | 持ち主の無い行の削除 |

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

- [x] `TASK_CRUD-FE-001`〜`007`
- [x] list / detail Presentation
- [x] lib resolver / viewmodel

### Backend（SIT）

- [x] `TASK_CRUD-SYS-001`〜`010` の実装分（001〜010、101〜102）

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

- Quick / Detail の統合
- 物理削除へ戻すこと
- 他人の Task を 403 で知らせること
- 終了予定日で STATUS を変えること
