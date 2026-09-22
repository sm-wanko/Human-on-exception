# Task CRUD UI

**Flow ID**: `TASK_CRUD`

## Surfaces

- task list page
- task detail page

## List

Uses `TaskQuick`.

Visible behavior:

- loading → `Loading…`
- empty → `No tasks yet.`
- failure → alert text
- success → title buttons/links for each task

The list must not require detail-only fields such as description.

## Detail

Uses `TaskDetail`.

Visible behavior:

- loading → `Loading…`
- failure/not found → error state
- success → title + description
- null description → `No description.`

## Navigation

Selecting a TaskQuick opens the corresponding detail route/page using the task id.

## Create/update forms

N/A in this example UI. The backend supports mutations, but the frontend sample intentionally demonstrates only list/detail read-model separation.
