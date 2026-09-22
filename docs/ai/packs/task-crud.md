# Pack: task-crud

## Scope

Includes:

- Laravel Task CRUD API reference implementation
- `TaskQuick` list projection
- `TaskDetail` detail projection
- Application port + Eloquent implementation
- migration/validation
- TypeScript list/detail UI sample
- Flow-linked backend/frontend test IDs

Does not include:

- authentication
- frontend mutation forms
- soft-delete/audit history
- full Laravel/Vite bootstrap scaffolding
- deployment/container setup

## Flow

- `TASK_CRUD`

## Four-document set

- [Flow](../../flow/task-crud.md)
- [UI](../../ui/task-crud.md)
- [Validation](../../validation/task-crud.md)
- [DB](../../db/task-crud.md)

## Decision history

- [Questions](../../testing/questions/task-crud.md)

## Architecture / rules

These are sample rules and may be replaced by adopters:

- [Backend architecture](../../architecture/backend.md)
- [Frontend architecture](../../architecture/frontend.md)
- [Dependency rules](../../architecture/dependency-rules.md)
- [PHP / Laravel](../../rules/php-laravel.md)
- [TypeScript frontend](../../rules/typescript-frontend.md)

## Implementation

Backend:

- `backend/app/Http/Controllers/TaskController.php`
- `backend/app/Application/Task/`
- `backend/app/Infrastructure/Persistence/EloquentTaskRepository.php`
- `backend/database/migrations/2026_09_22_000001_create_tasks_table.php`

Frontend:

- `frontend/src/features/task/`

## Tests / traceability

Backend:

- `backend/tests/Feature/TaskCrudTest.php`
- `TASK_CRUD-SYS-001..004`
- `TASK_CRUD-SYS-101..102`

Frontend:

- `frontend/src/features/task/presentation/TaskList.test.tsx`
- `TASK_CRUD-FE-001..004`

## Completion

Starter-level repository contract:

```bash
python scripts/repo_survey.py
```

CI runs the repository survey, Laravel Feature tests, TypeScript typecheck, and frontend contract tests for this sample.

A real project must replace/add its actual framework lint, architecture, dependency, migration, and test commands.

## Prohibitions

- do not introduce soft delete unless Q1 is intentionally reopened by a new product decision
- do not collapse Quick/Detail without a contract decision
- do not treat this example architecture as mandatory for adopters
