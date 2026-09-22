# Task CRUD DB

**Flow ID**: `TASK_CRUD`

## Table

`tasks`

| column | type | rule |
|---|---|---|
| id | bigint | primary key |
| title | varchar(200) | not null |
| description | text | nullable |
| created_at | timestamp | framework-managed |
| updated_at | timestamp | framework-managed |

## Ownership

Task persistence is owned by the Task repository implementation.

Controllers and frontend code do not query the database directly.

## Read path

- list: repository selects only `id,title` and returns `TaskQuick`
- detail: repository loads detail fields and returns `TaskDetail`

The Quick/Detail split is deliberate.

## Persistence

- create inserts one row
- update changes title/description
- delete is hard delete per Q1

## Transaction boundary

Each example mutation is one repository write and relies on Laravel's normal single-statement transaction semantics.

If a future use case spans multiple writes, the Application layer owns the explicit transaction boundary.

## Migration

- `backend/database/migrations/2026_09_22_000001_create_tasks_table.php`

## External side effects

N/A.
