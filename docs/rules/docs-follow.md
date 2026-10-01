# Documentation Synchronization

This rule defines how flow / ui / validation / db docs, transitions, and test IDs stay aligned in the **same change series**.

For N/A declarations, see [docs-na-conventions.md](./docs-na-conventions.md). For SIT strategy, see [system-test-strategy.md](./system-test-strategy.md).

The 4-point set is also a human-facing feature overview that lets people understand behavior and constraints without reading code. AI creates and maintains it in sync with current implementation and verification. Readers are not required to implement or perform line-by-line review.

Purpose/core concepts live in concept, adopted reasons in ADR, repeatable decisions in Policy. Follow [domain-decisions.md](./domain-decisions.md).

---

## MUST

- **Keep the 4-point set aligned in the same change series**: use `docs/flow/<feature>.md` as the anchor and update related `docs/ui` / `docs/validation` / `docs/db` in the same PR/change series.
- **`docs === implementation`**: Scope, Entry Point, Normal Flow, and the **test matrix** must not contradict implementation.
- **Use N/A only for genuinely absent responsibility**: omit a quadrant only when that responsibility does not exist, and mark the relevant doc explicitly N/A.
- **New screen/route**: update [`docs/transition/遷移定義.md`](../transition/遷移定義.md) in the same change series and run `make docs` / `make survey`.
- **Keep SYS-ID / FE-ID aligned**: backend vertical contracts use `*-SYS-*`; UI-origin contracts use `*-FE-*`; IDs must be traceable to test names.
- **SIT-impossible boundaries are reasoned N/A**: production-only external services, etc. must be marked N/A with a reason; do not confuse N/A with not implemented.

## 4-point responsibilities — do not copy prose across files

| Document | Owns |
|---|---|
| `flow` | user journey, API order, test matrix |
| `ui` | display and interaction |
| `validation` | input, auth, errors |
| `db` | persisted state, transactions, write results |

Do not duplicate the same response contract, happy-path prose, or error table across multiple files.

## Feature unit — 1 : bounded N

- A feature should normally have at most the 4-point set.
- For a new feature, start from `docs/templates/` or an existing set and keep the bundle cohesive.

## Completion when docs change

Run `make docs` / `make survey`. See root [`AGENTS.md`](../../AGENTS.md).
