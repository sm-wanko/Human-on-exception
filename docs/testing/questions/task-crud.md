# Task CRUD Questions

**Status**: IMPLEMENTED / EXAMPLE  
**Pack**: `task-crud`  
**Flow**: `TASK_CRUD`  
**Current contracts**: [Flow](../../flow/task-crud.md) · [UI](../../ui/task-crud.md) · [Validation](../../validation/task-crud.md) · [DB](../../db/task-crud.md)

## Human intent

Demonstrate the Human-on-Exception workflow on a familiar web feature while making repository rules, Questions, read-model ownership, docs, and tests visible.

The starter itself has already chosen Laravel + TypeScript for this **example only**. That choice is not a Human-on-Exception requirement.

## Repository findings

Resolved without human Questions:

- architecture rules already require thin Laravel HTTP layer
- Application orchestrates use cases
- persistence is repository-owned
- frontend uses feature-oriented TypeScript structure
- list/detail read models may differ
- Flow owns system/frontend test IDs

## Confirmed summary

| ID | Decision | Boundary |
|---|---|---|
| Q1 | hard delete | DELETE permanently removes the row |
| Q2 | title max 200 after trim | mutation validation |
| Q3 | list uses Quick; detail uses Detail | API/read-model boundary |

## Q1. Delete semantics

### Why this is unresolved

Hard delete and soft delete are both materially valid product/storage behaviors; repository architecture cannot decide product history requirements.

### Affected areas

- API delete behavior
- DB lifecycle
- tests

### Options

A. Hard delete
- minimal lifecycle semantics
- no recovery/history

B. Soft delete
- recoverable/history-friendly
- adds filtering and restore semantics outside the example goal

### AI recommendation

A. Keep the teaching feature focused on workflow and responsibility boundaries.

### Answer

A. Hard delete.

## Q2. Title constraint

### Why this is unresolved

The application needs a public input limit and no domain rule provides one.

### Options

A. non-empty only
B. trim then require non-empty and max 200

### AI recommendation

B. Explicit, testable, and maps cleanly to DB/API constraints.

### Answer

B.

## Q3. List and detail response shape

### Why this is unresolved

Both a universal Task DTO and separate list/detail projections are viable API designs.

### Options

A. One Task response everywhere
- simpler initial typing
- list path carries detail-only fields and encourages response growth

B. `TaskQuick` for list and `TaskDetail` for detail
- clearer query/response ownership
- slightly more types

### AI recommendation

B. It demonstrates an important practical boundary without exposing any project-specific production architecture.

### Answer

B.

## Implementation result

- current behavior moved into four-document contracts
- Pack points to Laravel/TypeScript implementation paths
- system/FE IDs are defined in Flow
- Questions remain decision history
