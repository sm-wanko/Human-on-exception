# System Integration Test Strategy

## Overview

This document defines the philosophy, terminology, and operating rules for **System Integration Tests (SIT)** under `apps/backend/tests/System/`.

SIT goal:

- **Human = unresolved UX intent and risk/acceptance decisions**. Optional UI inspection is allowed but is not a normal completion gate.
- **Machine = exhaustive communication patterns + DB state + cross-boundary contracts** within the automated deterministic scope.

This is not browser E2E. It verifies the vertical path **HTTP → Laravel → DB** through API contracts and persisted state.

### MUST: docs / implementation / SIT alignment

- Docs follow [docs-follow.md](./docs-follow.md).
- N/A follows [docs-na-conventions.md](./docs-na-conventions.md).
- Every `<FLOW>-SYS-NNN` in the Flow matrix must be extractable from a test name or data-provider name.

## 1. Three test layers

| Layer | Location | Responsibility | Tool |
|---|---|---|---|
| unit | `apps/backend/tests/Unit/` | isolated logic | PHPUnit |
| integration / feature | `apps/backend/tests/Feature/` | Laravel + real DB | PHPUnit / Laravel test |
| **system** | **`apps/backend/tests/System/`** | **HTTP → Laravel → DB vertical path** | PHPUnit / Laravel |
| frontend contract (API) | `apps/frontend/src/**/*.integration.test.tsx` | supporting check: interaction → API call | Vitest + RTL |
| **frontend flow contract** | `apps/frontend/src/lib/**/*.contract.test.ts` | supporting check: route/state/context continuity | Vitest pure resolver |

**System is primary** for persistence/cross-boundary backend behavior. Frontend tests are complementary.

Frontend Flow Contract is defined in [`docs/testing/frontend-flow-contract.md`](../testing/frontend-flow-contract.md).

### 1.1 Frontend API-call contract boundary

Frontend integration verifies that the expected API is called with the expected method/URL/payload. DB state and cross-service side effects are outside that test's scope.

### 1.2 Frontend Flow Contract

Core journey branching, route, and context continuity use pure resolvers + `*-FE-*`.

---

## 2. Flow IDs

- positive: `<FLOW>-SYS-001`–`099`
- reverse/negative: `<FLOW>-SYS-101`–`199`
- frontend: `<FLOW>-FE-NNN`

Flow IDs must exactly match between the `docs/flow/<feature>.md` matrix and test names.

---

## 3. What SIT verifies

Positive path:

1. request — method/path/payload
2. response — status/body
3. DB state
4. side effects when applicable

Reverse path:

- status/body
- **no unintended DB write**
- no side effect when it must not fire

---

## 4. Authentication / audit

When adding or changing a member-facing mutation, follow [audit-ui-persistence.md](./audit-ui-persistence.md) and assert audit values in the positive SIT.

### 4.1 Audit assertions

- `created_by` / `created_app`
- `updated_by` / `updated_app` on update
- seed/migration-origin rows are excluded

If authentication is N/A for a Flow, state N/A in flow / validation.

---

## 5. External boundaries

Paid APIs, OAuth, real email, or other paths that cannot be deterministic local vertical tests are reasoned N/A in the Flow matrix. When stubbing is appropriate, verify the request contract.

---

## 6. Frontend boundary

- do not run every UI matrix row through RTL
- pure branching → contract test
- representative user interaction → integration test
- DB/persistence → system test

---

## 7. Completion

- `make test`
- when flow / SYS / FE changes, run `make survey`
- if a gap remains, state whether it is unimplemented or N/A
