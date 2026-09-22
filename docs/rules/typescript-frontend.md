# TypeScript Frontend Quick Rules

**Scope**: the TypeScript/React sample only. Adopting repositories may replace these rules.

## MUST NOT

- Presentation/component performs direct network requests
- page component becomes a business/service layer
- hook duplicates domain/display decision logic across screens
- the same API response type is redefined in multiple components
- `any` is used without an explicitly documented unsafe boundary
- server/API state is mirrored into local state without a real UI-state reason
- list consumers are forced to depend on Detail-shaped data without need
- API errors are silently swallowed
- docs alone are used to delete current working behavior/tests

## Responsibility table

| Area | Owns | Must not own |
|---|---|---|
| api | request/response mapping, transport types, normalization | React rendering, product presentation decisions |
| pure model/lib (when needed) | derived/domain/display decisions as pure functions | hooks, JSX, network/browser I/O |
| hooks | state, effects, orchestration, calling api/pure model | duplicated business/display rules |
| presentation | rendering explicit props, local interaction callbacks | fetch, API interpretation, business decisions |
| pages/routes | route composition, wiring hooks/presentation | reusable feature rules |
| types | feature-local UI/form/read-model types | duplicate transport truth |

Do not create a pure-model/lib layer for trivial pass-through code. Add it when a decision/derivation needs one reusable source of truth.

## API / read models

- `TaskQuick` and `TaskDetail` demonstrate intentionally different contracts
- list UI consumes Quick
- detail UI consumes Detail
- transport shapes should be explicit
- API contract changes require Flow/Validation updates

## State

Use local state for actual UI state:

- loading
- modal/tab/open state
- temporary form input
- error display

Prefer deriving values from current inputs instead of synchronizing duplicate derived state.

## UI contract

For user-visible changes, UI docs cover applicable:

- loading
- empty
- error
- permission/disabled
- navigation/return/context continuity

## Testing

- pure decision/normalization → unit/contract test
- route/context branching → FE-ID contract test
- representative user interaction → integration test
- persistence/cross-service side effects → backend/system test

Do not turn frontend tests into a duplicate database/system test layer.

Real projects must encode their actual router/SSR/client-state/testing conventions.
