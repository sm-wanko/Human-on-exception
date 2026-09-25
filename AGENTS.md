# AI Agent Rules (Human-on-Exception)

**Target agents**: Cursor / Claude Code / CodeX.

**Feature index**: [`docs/testing/core-features.md`](./docs/testing/core-features.md) → [`docs/ai/packs/`](./docs/ai/packs/) (paths + Flow IDs + completion `make` commands only; do not copy flow bodies into packs).

---

## Execution and decisions

Apply the [AI execution contract](./docs/rules/ai-workflow.md) to every stage. Humans own Intent / Scope / Answer / Risk acceptance. AI owns execution. Human code review is not a required gate.

Follow the [language policy](./docs/rules/language-policy.md). Agent-facing rules are English. Human-facing decision material may be bilingual, and translation must not change meaning.

## Review guidelines

When Codex is invoked as a PR reviewer, apply the [independent AI review contract](./docs/rules/ai-review.md). The reviewer is not the implementation agent described below. It independently checks the Issue AC, diff, rules, and tests from a separate context.

## Minimal reading order

0. **Core feature bundle**: [`docs/testing/core-features.md`](./docs/testing/core-features.md) — index of the relevant pack and Flow IDs.
1. **Issue / PR** — Flow ID, allowed paths, prohibitions. Before an Issue exists, identify the relevant bundle from the request.
   - If the task changes purpose, terminology, aggregation units, actor boundaries, or evidence meaning, read the relevant [concept](./docs/concept/README.md), active ADR, and Policy first according to [domain decision inheritance](./docs/rules/domain-decisions.md).
2. **Exactly one relevant flow**: `docs/flow/<feature>.md` — Scope and matrix rows. Read only the relevant 4-point docs when needed.
3. **Corresponding tests**: `*-SYS-*` → `apps/backend/tests/System/`; `*-FE-*` → `apps/frontend/src/**/*.contract.test.ts` / `*.integration.test.tsx`.
4. **Implementation files**: manifest in the Issue / PR or `docs/ai/packs/<bundle>.md`.
5. **Rules**: always read `docs/rules/backend-quick.md` / `frontend-quick.md` for touched BE/FE areas. Read detailed conventions only when needed.

## Avoid during initial exploration

- `coverage/docs/*` generated output
- cross-repository grep of every file under `docs/flow/`
- full `TECH_STACK.md` / `README.md` unless the relevant section is needed
- reading every file in `docs/rules/*`; open only rules relevant to the touched area

---

## Required for every task

1. Follow reading order **0→5**. Read one relevant flow and one relevant pack, not the whole repository by default.
2. Every created Issue / PR must include **Pack**, **Flow ID**, **allowed paths**, and completion **`make`** commands.
3. Before completion, run the required `make lint-*` / `make test-*` commands below. For structural changes, also run `make survey` as applicable. Add PHPDoc / JSDoc to touched exported/public surfaces.
4. Use `make` or the app's existing commands for verification. Do not make an ad-hoc environment the source of truth.

## Completion requirements

| Change area | Minimum | When structure/docs change |
|---|---|---|
| Backend | root `make lint` → `cd apps/backend && make test` | same + `make survey` for the relevant flow |
| Frontend | root `make lint` → `cd apps/frontend && make test` | `make survey` / `make docs` when flow or route changes |
| Cross-cutting | `make test` | `make survey` / `make docs` |

---

## Source of Truth when current-state sources conflict

1. implementation → 2. system test → 3. `docs/flow` → 4. generated `coverage/*`

Do **not** delete existing implementation or tests based only on docs. This order is for determining current-state facts. Once a change is agreed, the target contract comes from Answers / Issue AC according to [AI execution contract §6](./docs/rules/ai-workflow.md).

**Current facts** live in code + the 4-point set (flow / ui / validation / db). **Decision history** lives in [`docs/testing/questions/`](./docs/testing/questions/) and [`docs/testing/adr/`](./docs/testing/adr/). Do not put decision history into the 4-point set.

Concept holds purpose and core concepts. ADR holds active design decisions. [Policy](./docs/testing/policy/README.md) holds agreed repeatable criteria. AI maintains and verifies the human-facing 4-point feature overview; human code review and document approval are not normal gates.

---

## Prohibited without explicit request / decision

- changing API parameters or response contracts
- adding, removing, or changing business logic
- removing authentication, CORS, or security configuration
- rewriting the layer structure or adding business logic to Laravel bootstrap / route wiring
- treating an external boundary marked N/A in a flow as completed

---

## Rules to open when needed

| Touched area | Rule |
|---|---|
| Laravel Backend | [`backend-quick.md`](./docs/rules/backend-quick.md) always; [`backend-coding-conventions.md`](./docs/rules/backend-coding-conventions.md) only for details |
| Frontend | [`frontend-quick.md`](./docs/rules/frontend-quick.md) always; [`frontend-coding-conventions.md`](./docs/rules/frontend-coding-conventions.md) only for details |
| flow / docs synchronization | [`docs-follow.md`](./docs/rules/docs-follow.md) |
| N/A declarations | [`docs-na-conventions.md`](./docs/rules/docs-na-conventions.md) |
| SIT / FE Contract | [`system-test-strategy.md`](./docs/rules/system-test-strategy.md), [`frontend-flow-contract.md`](./docs/testing/frontend-flow-contract.md) |
| member-facing mutation audit | [`audit-ui-persistence.md`](./docs/rules/audit-ui-persistence.md) |
| translation / bilingual docs | [`language-policy.md`](./docs/rules/language-policy.md) |
