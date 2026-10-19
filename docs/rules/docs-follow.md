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
| `db` | persisted state, transactions, and write results, written as SQL |

Do not duplicate the same response contract, happy-path prose, or error table across multiple files.

The 4-point set is readable without opening implementation files. A source path does not replace the behavior.

`db` writes the statement for each write step, and for each read that decides a branch, a lock, a conflict, or a version check. Include the `WHERE`, `ON CONFLICT`, or `FOR UPDATE` that decides the result. Use this repository's placeholders (`?` or `$1`). A path to a repository file does not satisfy the SQL section. `flow` names the journey and links to `db` for those statements. `ui` and `validation` do not repeat them.

Inconsistent current behavior, estimates that were not executed, and tests that do not exist belong in `docs/flow` under `## 未検証事項・矛盾`. The other three files get one sentence and a link. Do not copy the list, and do not turn it into an accepted design. A matrix row marked `未実装` is missing evidence, not a test that exists.

A finding that touches more than one quadrant still updates each affected file in the same change series. The non-owning file gets one sentence and a link. It does not get a second copy of the prose. Review replies stay in the PR. Do not append them to the 4-point set.

Example: a confirm retry identified by an operation key, and a later migration that adds columns for rows already stored.

| Fact | Write it in | In the other files |
|---|---|---|
| What the screen keeps, disables, or discards while the retry is in flight | `ui` | one sentence and a link |
| Key format, and the 400 when the same key is sent with a different payload | `validation` | one sentence and a link |
| The operation table, the lock, the stored request hash, and the response saved in the same transaction | `db` | one sentence and a link |
| The user-visible order of preview and confirm, and the SYS/FE matrix row | `flow` | do not copy the matrix |
| Migration order, and that existing rows keep their values while new columns stay null | `db` | `flow` keeps a single matrix row. `ui` and `validation` do not describe the migration |

## Feature unit — 1 : bounded N

- A feature should normally have at most the 4-point set.
- For a new feature, start from `docs/templates/` or an existing set and keep the bundle cohesive.

## Completion when docs change

A change that touches a route, a flow test matrix, or flow / ui / validation / db structure runs `make survey` on that head. The integration head still runs full `make survey` with full `make test`. See root [`AGENTS.md`](../../AGENTS.md) and [ai-workflow.md](./ai-workflow.md) §4.
