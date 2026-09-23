# コア機能 × Flow 束 × pack

AI が初期探索で読む索引。実装本文は書かず、**束・Flow ID・実装パス・pack**だけを持つ。

| # | 束 | Pack | Flow ID | 主な実装 |
|---|----|------|---------|----------|
| 1 | Task CRUD | `task-crud` | `TASK_CRUD` | `apps/backend/app/Application/Task/`, `apps/frontend/src/lib/task/`, `apps/frontend/src/features/task/` |

## 束（pack）一覧

| Pack | Flow | 完了 |
|------|------|------|
| [task-crud](../ai/packs/task-crud.md) | `TASK_CRUD` | `make lint` → `make test` → `make survey` |

Done 定義: [bundle-completion.md](./bundle-completion.md)
