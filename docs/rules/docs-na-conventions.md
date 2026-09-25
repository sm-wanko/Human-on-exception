# Documentation N/A Conventions

## Purpose

When an API has no DB read/write responsibility or no client-input validation responsibility, explicitly declare that dimension **N/A** so it is distinguishable from missing documentation.

## Principles

### Current contract only

`docs/flow` / `docs/ui` / `docs/validation` / `docs/db` describe the **current implementation and current contract**.

- **Include**: current API contract, DB state, SIT expectations.
- **Do not include**: old status, old IDs, migration history.
- Decision history belongs in `docs/testing/questions/`; active decisions belong in `docs/testing/adr/`.

### Meaning of N/A

- N/A is an explicit specification that the dimension has no responsibility.
- DB non-participation belongs in `docs/db/*.md`.
- Validation non-applicability belongs in `docs/validation/*.md`.
- Do not use N/A to erase other responsibilities such as external API, cache, or auth.

## Standard section names — exact strings are part of the current contract

The existing Japanese headings are intentionally preserved because repository surveys may depend on exact text.

### DB docs

```markdown
## DB 非関与エンドポイント（N/A）
```

### Validation docs

```markdown
## バリデーション非適用エンドポイント（N/A）
```

Do not translate or rename these headings unless the corresponding survey/tooling and docs contract are changed in the same authorized change.

## Recommended table

| method | path | behavior | implementation |
|---|---|---|---|
| GET | `/api/example` | returns a fixed value without DB access | `apps/backend/...` |

## Review checks

- Standard section heading matches the repository convention.
- method/path matches the implemented route.
- N/A reason has implementation evidence.
- N/A is not hiding a different responsibility.

## Anti-patterns

- declaring N/A while touching DB
- declaring N/A while input validation is required
- using "not investigated" or "probably unnecessary" as an N/A reason
- hiding missing API specification behind N/A

## Out-of-scope SIT paths

For boundaries intentionally excluded from vertical SIT in a `docs/flow/*.md` test matrix, use the exact current heading below and record path + reason:

```markdown
### SIT スコープ外（N/A）
```

 Do not confuse this with unfinished implementation.
