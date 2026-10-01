# Backend Coding Conventions — Detailed Reference

> **AI (Cursor / Claude Code / CodeX)**: the always-read source of truth is [backend-quick.md](./backend-quick.md).  
> This file provides deeper examples and procedures. MUST / prohibitions / layer responsibilities remain authoritative in quick; do not duplicate them here.

**Scope**: `apps/backend/` only.

---

## Mapping to quick

| Topic | Source |
|---|---|
| MUST NOT / completion | [backend-quick.md §1, §10](./backend-quick.md) |
| Layer responsibilities / placement | [§2, §3](./backend-quick.md) |
| Errors / DB summary / logs / naming | [§4–7, §9](./backend-quick.md) |
| **Tx boundary / migration detail** | **this file: Tx / Migration** |
| **PHPDoc** | quick §8 + this file: Comments |
| Tests | quick §10 + this file: Tests |

---

## Project structure reference

```
apps/backend/
├── app/
│   ├── Http/Controllers/      # handler equivalent
│   ├── Http/Requests/         # HTTP validation
│   ├── Http/Resources/        # API response
│   ├── Services/              # business / orchestration
│   ├── Repositories/          # persistence
│   ├── DTO/                   # Quick / Detail etc.
│   └── Models/
├── database/migrations/
├── routes/
└── tests/
    ├── Unit/
    ├── Feature/
    └── System/
```

---

## Controller example

```php
public function show(int $task, TaskService $service): JsonResponse
{
    $detail = $service->getDetail($task);

    return response()->json($detail->toArray());
}
```

Controller only binds, maps status, and returns the response.

---

## Service — exception normalization example

```php
public function getDetail(int $id): TaskDetail
{
    $task = $this->tasks->findDetail($id);

    if ($task === null) {
        throw new TaskNotFoundException($id);
    }

    return $task;
}
```

---

## Repository — query example

```php
public function listQuick(): array
{
    return Task::query()
        ->select(['id', 'title'])
        ->orderBy('id')
        ->get()
        ->map(fn (Task $task) => new TaskQuick($task->id, $task->title))
        ->all();
}
```

---

## Transaction boundary

- **Single Repository / single write**: may complete inside Repository.
- **Multiple Repositories / writes requiring atomicity**: Service orchestrates with `DB::transaction`.
- Do not treat external HTTP/Queue side effects as DB-rollbackable. Use outbox/after-commit or another explicit design when required.

## Query philosophy — use-case specific

- If list and detail read different columns/relations, separate the queries.
- Avoid a giant universal query or flag maze.
- Preserve bindings and N+1 avoidance.
- Do not force Quick / Detail into one DTO.

---

## Comments / PHPDoc

Quick §8 is authoritative; this is supplemental.

| Kind | Rule |
|---|---|
| public class/method | document non-obvious input/output/side effects/authorization |
| complex public surface | roughly 2–4 lines when useful |
| touched public surface | fill missing docs in the same PR |
| prohibited | full specification copies or docs-metadata-only comments |

---

## Migrations

| Command | Use |
|---|---|
| `php artisan migrate` | apply to latest |
| `php artisan migrate:rollback` | rollback |
| `php artisan make:migration ...` | create migration |

- Laravel migration is authoritative.
- For destructive changes, inspect existing data and rollout.
- Do not mix seed/fixture data into migration responsibility.

---

## Tests

| Command | Scope |
|---|---|
| `make test` | PHPUnit Feature / Unit |
| `php artisan test` | Laravel tests |

For SIT, see [system-test-strategy.md](./system-test-strategy.md).

---

## Automated iterative AI review

1. Review current state → 2. Fix → 3. Review again → 4. repeat until no MUST violation remains.

**Done**: no MUST violation, unresolved items stated, impact explainable, and test coverage added or demonstrably existing.
