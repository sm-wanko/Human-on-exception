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

## Standard section names

### DB docs

```markdown
## DB Non-Participation Endpoints (N/A)
```

### Validation docs

```markdown
## Validation-Not-Applicable Endpoints (N/A)
```

Existing project-specific headings may remain when surveys depend on exact text; change them only with the corresponding tooling/docs update.

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

For boundaries intentionally excluded from vertical SIT in a `docs/flow/*.md` test matrix, use the repository's standard **SIT out-of-scope (N/A)** section and record path + reason. Do not confuse this with unfinished implementation.
