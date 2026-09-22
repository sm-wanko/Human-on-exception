# Task CRUD Validation

**Flow ID**: `TASK_CRUD`

## POST /api/tasks and PATCH /api/tasks/{id}

Body:

```json
{
  "title": "Buy milk",
  "description": "2L"
}
```

Rules:

- `title`: required string, trim before validation/persistence, max 200
- blank-after-trim title: rejected
- `description`: nullable string, max 2000

## Errors

Laravel validation failure:

- 422
- no DB mutation

Unknown task:

- 404

## Authentication / authorization

N/A. Authentication is intentionally outside this sample feature.

## Response contract

List response uses `TaskQuick`:

- id
- title

Detail/create/update response uses `TaskDetail`:

- id
- title
- description
- created_at
- updated_at
