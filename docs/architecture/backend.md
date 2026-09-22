# Backend Architecture

This repository includes a **sample** backend architecture for the Task CRUD example.

It is a pragmatic layered design inspired by Clean Architecture. It is not a Human-on-Exception requirement.

## Example dependency direction

```text
HTTP / Laravel
      ↓
Application use cases
      ↓
Application ports / read models
      ↑
Infrastructure implements ports
```

A Domain layer is added only when the project has real domain behavior that benefits from one. The trivial Task CRUD intentionally does not create a ceremony-only Domain layer.

## Responsibilities

### HTTP / Laravel

Owns:

- routes
- Controllers
- FormRequest entry validation
- HTTP status/response mapping

Must stay thin.

### Application

Owns:

- use-case orchestration
- repository/port contracts required by the use case
- caller-facing read models when they are application query projections
- transaction boundaries for multi-write use cases

Examples:

- `ListTasks`
- `GetTaskDetail`
- `CreateTask`
- `TaskRepository` port
- `TaskQuick` / `TaskDetail`

### Infrastructure

Owns:

- Eloquent persistence implementation
- framework/database-specific query details
- external clients

Infrastructure implements Application ports.

### Domain (optional)

Use a Domain layer when there are stable business rules/entities/value objects worth isolating.

Do not create a Domain layer only because an architecture diagram contains one.

## Quick vs Detail

Read models are caller-shaped.

- `TaskQuick`: list/card projection
- `TaskDetail`: detail projection

Do not widen list queries/responses merely because detail data exists.

## Prohibitions in this sample

- Controller → Eloquent feature query
- Application → Laravel Request
- Application → concrete Infrastructure repository
- Infrastructure → HTTP response
- generic repository abstraction across unrelated features by default

## Adopt, adapt, or replace

Real projects should keep, simplify, or replace this structure based on their own scale and constraints, then encode that decision in project-specific rules.
