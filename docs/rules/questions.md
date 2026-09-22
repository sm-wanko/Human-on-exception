# Questions Rule

## Purpose

Questions exist to protect human attention.

The agent must turn human intent into a bounded implementation plan while asking only for decisions the repository cannot safely make on its own.

Questions are a **decision protocol**, not a checklist of everything the agent does not immediately know.

---

## Before writing a Question

Investigate, as applicable:

1. `AGENTS.md`
2. `docs/testing/core-features.md`
3. the relevant Pack
4. project architecture / language rules
5. current Flow / UI / Validation / DB
6. matching SYS / FE tests
7. implementation paths
8. relevant ADRs / prior Questions when rationale/history is needed
9. neighboring implementations with the same responsibility

If repository evidence resolves the issue, record it as a **repository finding**, not as a Question.

Do not make the human rediscover facts already encoded in the repository.

---

## Questions document must separate fact from decision

A strong Questions document contains four distinct layers:

### 1. Human intent

What the human wants and why, including:

- desired user/system outcome
- important examples or attachments
- non-negotiable constraints explicitly stated by the human

Do not silently reinterpret the request into a broader goal.

### 2. Current repository facts

Record facts discovered from current evidence, with source paths where useful:

- existing behavior
- existing APIs/routes
- persistence ownership
- existing test coverage
- already-fixed architecture/rules
- already-decided historical constraints still relevant

This section should make clear **what is not being asked again**.

### 3. Open decisions

Only unresolved choices that materially need human judgment.

### 4. Confirmed decisions / implementation handoff

After Answers:

- normalize decisions into concise boundaries
- record which prior assumptions/decisions are superseded
- identify affected Flow/Pack/docs/tests
- derive Issue/Epic split and merge order
- declare explicit non-scope

---

## Analysis lenses before declaring "no Questions"

The agent must actively check the relevant lenses below.

These are **analysis lenses, not mandatory Questions**.

### Scope / product / UX

- what exact outcome changes?
- what remains unchanged?
- success / empty / partial / error behavior
- visibility / permissions / default / fallback behavior
- whether a neighboring feature must remain parity-compatible or intentionally differ

### Contract / compatibility

- API method/path/request/response changes
- route/query/context continuity
- existing clients/callers
- backward compatibility / rollout sequencing
- externally observable error/fallback semantics

### Data / persistence

- source of truth / ownership
- read model vs write model
- migration/backfill/seed/master data
- transaction/rollback
- uniqueness/concurrency/idempotency
- destructive/irreversible changes

### Security / privacy / audit

- authentication/authorization
- data exposure
- fail-open/fail-close
- audit/history requirements
- ownership checks

### External / async / cache

- downstream calls
- timeout/retry behavior
- required vs best-effort side effects
- cache key/invalidation/version
- jobs/events/eventual consistency

### Architecture / maintainability

- layer/module ownership
- dependency direction
- shared abstraction vs local implementation
- existing project rule/ADR that already fixes the choice
- whether a proposed "cleanup" changes behavior or only implementation

### Verification / operations

- normal and negative Flow cells
- request/response/DB/side-effect assertions
- FE context/route contract
- failure/recovery/rollback
- monitoring/operational contract only when materially relevant

### Delivery / decomposition

- one reviewable Issue vs Epic
- child dependencies and merge order
- docs/Pack/index changes
- compatibility/migration sequencing
- explicit out-of-scope items

Before saying "no further Questions", verify that no materially different valid option remains in these lenses.

---

## When a Question is warranted

Ask when at least one of these is true:

- multiple materially valid product/UX outcomes remain
- a public/API/storage contract could change
- an existing behavior may intentionally be broken or preserved
- a migration may be destructive, irreversible, or rollout-sensitive
- privacy/security/audit behavior requires a boundary decision
- current sources conflict and evidence cannot resolve intent
- a choice establishes a long-lived architecture/ownership boundary
- a choice depends on human product/business intent not encoded anywhere

## When a Question is not warranted

Do not ask when:

- current rules/contracts/tests/code already answer it
- there is one established local pattern with no meaningful external tradeoff
- it is naming/style/formatting
- it is routine implementation mechanics
- it is a reversible internal detail with no significant contract/risk effect
- the agent can investigate/verify the answer itself

Do not create fake Questions merely to show diligence.

---

## Required Question shape

Each unresolved decision must contain:

```markdown
## Q<n>. <decision title>

### Why this is unresolved
<what was inspected and what remains undecidable>

### Existing constraints / affected areas
- current behavior that must be preserved unless explicitly changed
- product/UX
- API/contract
- DB/migration
- security/audit
- tests/docs
- dependencies/rollout

### Options
A. ...
- benefits
- costs / risks
- compatibility impact

B. ...
- benefits
- costs / risks
- compatibility impact

### AI recommendation
<recommended option and repository-grounded reason, or "no recommendation">

### Answer
PENDING
```

Not every affected-area bullet must be populated; include only material ones.

---

## Answer loop

After the human updates Answers:

1. re-read **all** Answers, not only the newest one
2. convert Answers into a concise Confirmed Decisions table
3. detect contradictions with:
   - current contracts
   - prior confirmed Answers
   - ADRs
   - protected behavior
4. identify any previously valid decision now superseded
5. re-run only the analysis lenses affected by changed assumptions
6. append only genuinely new blocking Questions
7. do not reopen settled Questions without new evidence
8. when no blocking ambiguity remains, stop asking and create Issues

A new Answer may expose a second-order decision. That is the intended LOOP.

The goal is **not** to finish in one Question pass; the goal is to stop human interaction as soon as the boundary is truly closed.

---

## Confirmed Decisions section

Once answered, maintain a compact table such as:

| ID | Decision | Boundary / consequence | Supersedes |
|---|---|---|---|
| Q1 | hard delete | DELETE physically removes the row | — |

For large changes, group by concern (scope, API, data, UX, test/delivery) if that is clearer.

Do not force the human to reread every question body to understand the final design.

---

## Issue creation rule

When all blocking Questions are answered:

- create one Issue for a cohesive, independently reviewable change
- create an Epic + child Issues when sequencing, independent workstreams, migration phases, or review size justify it
- child Issues reference the Epic
- include explicit dependency / merge order
- derive acceptance criteria from confirmed decisions + current contracts
- include:
  - Pack / Flow
  - allowed/touched areas
  - protected/non-scope behavior
  - docs to update
  - SYS/FE test strategy
  - migration/compatibility notes
  - completion commands/checks

Do not copy the entire Questions document into every Issue. Issues are implementation slices; the Questions document remains decision history.

---

## Lifecycle / Source of Truth

Typical lifecycle:

```text
PENDING → ANSWERED → ISSUES_CREATED → IMPLEMENTED → HISTORICAL
```

After implementation:

- current behavior belongs in implementation/tests/Flow/UI/Validation/DB
- durable cross-feature rationale may be captured in ADR
- Questions remain decision history
- Questions must not override newer current-contract facts

Questions may remain discoverable after implementation; "historical" does not require deleting them.
