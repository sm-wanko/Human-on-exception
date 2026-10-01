# Frontend Quick Rules (Always Read)

**Scope**: `apps/frontend/` only.  
**AI**: this file is authoritative. Read [frontend-coding-conventions.md](./frontend-coding-conventions.md) only for detailed examples/background.

| Situation | Read |
|---|---|
| Frontend implementation/fix | **this file** |
| apiClient/JSDoc/navigation examples | [frontend-coding-conventions.md](./frontend-coding-conventions.md) |
| Flow Contract | [frontend-flow-contract.md](../testing/frontend-flow-contract.md) |

---

## 1. MUST NOT

- put **display meaning/domain branching** in hooks/components/features; authoritative logic belongs in **`lib/<domain>`**
- build business branching or ViewModels inside `useMemo` / `useCallback`; their body should call one lib function
- let UI directly interpret API responses into display state; go through `build*` / `resolve*`
- implement different display logic for the same input in multiple files
- create `features/<domain>/lib/`; use **`src/lib/<domain>/`**
- fetch outside `apiClient`
- delete implementation/tests based only on docs; current-state SoT is implementation → test → flow

---

## 2. Layer responsibilities

| Layer | MUST | MUST NOT |
|---|---|---|
| **app/** | route wiring, feature imports | domain rules, complex transformation |
| **api/** | fetch, transport types, normalize | ViewModel, screen copy decisions |
| **lib/** | **single source of truth for display state / ViewModel** using pure functions | hooks, JSX, browser I/O |
| **hooks/** | state, side effects, **lib calls** | domain `if`, structure assembly |
| **features/** | domain screen Presentation | fetch, domain computation, long branching |
| **components/** | pure UI | fetch, domain decisions |
| **types/** | FormValues, filters, page state | sole source for raw API DTO |
| **utils/** | domain-agnostic technical helpers | domain decisions |

**Flow**: fetch in `api` → assign meaning in **`lib`** → hooks place result in state → features/components render.

---

## 3. lib vs hooks — critical boundary

- **MUST**: derived values/display policy live in `lib` functions named `buildXxx` / `resolveXxx`.
- **MUST**: hooks call lib functions; do not copy branch logic into hooks.
- **Allowed in hooks**: loading/null guard, modal open/close, tabs and other UI state.

---

## 4. Placement

```
src/
├── app/                 # wiring
├── api/                 # transport/types/normalize
├── lib/<domain>/        # source of truth
├── features/<domain>/   # Presentation
├── hooks/<domain>/      # state + lib calls
├── components/          # pure UI
├── types/
└── utils/
```

---

## 5. API

- all requests go through `apiClient.ts` `request`
- do not build ViewModels in the API layer
- avoid unnecessary client re-fetches

---

## 6. Types / naming

| Kind | Location |
|---|---|
| API request/response | `api/` |
| FormValues/page state | `types/` |
| ViewModel creation | functions in **`lib/`**; types in `types/` or adjacent to lib |

- Component: PascalCase
- ViewModel helpers: `build*` / `resolve*` / `find*`

---

## 7. JSDoc — MUST

- exported function/type/component → at least one `/** */` comment immediately before declaration
- if an exported surface is touched in the PR, do not leave missing JSDoc behind

---

## 8. ESLint / formatting

- TypeScript strict
- follow app Prettier / ESLint configuration
- `any` only when the boundary reason can be stated

---

## 9. Navigation / route additions

In the same PR, update `docs/transition/遷移定義.md` and run `make docs` / `make survey`. See [docs-follow.md](./docs-follow.md).

---

## 10. Tests / completion

| Kind | Location |
|---|---|
| Flow contract | `lib/<domain>/**/*.contract.test.ts` with 1:1 FLOW-ID traceability |
| Integration | `*.integration.test.tsx` for representative journeys |
| Vitest | `*.test.ts` / `*.spec.ts` |

**Principle**: branching belongs in a resolver (lib). The authoritative contract is the `*-FE-*` matrix in `docs/flow/<feature>.md`.

**Before frontend completion**: root `make lint` → `cd apps/frontend && make test`. See [frontend-coding-conventions.md](./frontend-coding-conventions.md).
