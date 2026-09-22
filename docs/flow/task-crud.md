# Task CRUD Flow

**Flow ID**: `TASK_CRUD`  
**Pack**: `task-crud`

## Scope

Demonstrate Human-on-Exception on a small Laravel + TypeScript feature using pragmatic layered architecture and distinct Quick/Detail read models.

## Entry points

Backend:

- `GET /api/tasks`
- `GET /api/tasks/{id}`
- `POST /api/tasks`
- `PATCH /api/tasks/{id}`
- `DELETE /api/tasks/{id}`

Frontend:

- task list page
- task detail page

## Normal flow

1. List requests use `TaskQuick` and do not include detail-only fields.
2. Detail requests use `TaskDetail`.
3. Create validates input via Laravel FormRequest and returns the created detail projection.
4. Update returns the updated detail projection.
5. Delete permanently removes the task.

## Alternate / error flow

- blank/invalid title → 422 and no mutation
- unknown detail/update/delete id → 404
- frontend loading state is visible while awaiting data
- frontend request failure is rendered as an error state
- empty task list renders an explicit empty state

## Test matrix

| ID | Scenario | Expected response | Expected DB state | Side effects |
|---|---|---|---|---|
| `TASK_CRUD-SYS-001` | create then list | 201 then 200; list uses Quick shape | one trimmed-title row | none |
| `TASK_CRUD-SYS-002` | detail | 200; Detail contains description | unchanged | none |
| `TASK_CRUD-SYS-003` | update | 200 | title/description updated | none |
| `TASK_CRUD-SYS-004` | delete | 204 | row removed | none |
| `TASK_CRUD-SYS-101` | blank title | 422 | unchanged | none |
| `TASK_CRUD-SYS-102` | unknown id | 404 | unchanged | none |

### Frontend contract

| ID | Scenario | Expected |
|---|---|---|
| `TASK_CRUD-FE-001` | list loading | loading state shown |
| `TASK_CRUD-FE-002` | list empty | explicit empty state |
| `TASK_CRUD-FE-003` | request failure | error state shown |
| `TASK_CRUD-FE-004` | open task | detail page uses Detail API |
