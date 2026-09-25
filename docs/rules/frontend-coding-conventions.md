# Frontend Coding Conventions — Detailed Reference

> **AI (Cursor / Claude Code / CodeX)**: the always-read source of truth is [frontend-quick.md](./frontend-quick.md).  
> This file provides deeper examples/procedures. MUST rules, layer responsibility, and lib ownership remain authoritative in quick.

**Scope**: `apps/frontend/` only.

---

## Mapping to quick

| Topic | Source |
|---|---|
| MUST NOT / completion | [frontend-quick.md §1, §10](./frontend-quick.md) |
| Layer / lib-hooks boundary | [§2, §3](./frontend-quick.md) |
| Placement | [§4](./frontend-quick.md) |
| API / types / naming | [§5–6](./frontend-quick.md) |
| **JSDoc** | quick §7 + this file: Comments |
| Navigation | quick §9 + this file: Navigation |
| Tests / Flow Contract | quick §10 + [frontend-flow-contract.md](../testing/frontend-flow-contract.md) |

---

## Project structure reference

```
apps/frontend/src/
├── app/
├── api/
├── lib/<domain>/
├── features/<domain>/
├── components/
├── hooks/<domain>/
├── types/
└── utils/
```

---

## API request example

```typescript
export async function request<T>(url: string, options?: RequestInit): Promise<T> {
  const response = await fetch(url, options)
  if (!response.ok) throw new Error(`HTTP ${response.status}`)
  return response.json() as Promise<T>
}
```

Transport belongs in api; meaning belongs in lib.

---

## Example lib subdivision

`lib/task/` — pure functions such as `buildTaskListViewModel`, `resolveTaskDetailState`.

### Example hook split

- `useTaskListQuery` — fetch + lib call
- `useTaskActions` — navigation/mutation
- Presentation only renders hook output

---

## Comments / JSDoc

Quick §7 is authoritative. Add JSDoc to touched exported surfaces in the same PR.

```typescript
/** Builds the Task view model used by list presentation. */
export function buildTaskListViewModel(tasks: TaskQuick[]): TaskListViewModel {
  // ...
}
```

---

## Navigation documentation

When route / Link / navigate changes, in the **same PR**:

1. update `docs/transition/遷移定義.md`
2. run `make docs`
3. run `make survey`

---

## Automated iterative AI review

1. Review current state → 2. Fix → 3. Review again → 4. repeat until no prohibited violation remains.

**Done**: no prohibited violation, unresolved items stated, impact explainable, and tests added or demonstrably existing.
