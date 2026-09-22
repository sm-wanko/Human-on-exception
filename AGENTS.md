# Agent Contract

## Goal

Keep humans out of routine implementation and review work.

The canonical human/AI responsibility split is defined in `docs/rules/responsibility-boundary.md`. If another document is ambiguous about who owns a task, that boundary wins unless a project-specific safety/compliance rule explicitly requires human involvement.

Humans own:

- intent
- rationale
- product/experience direction
- non-negotiable boundaries
- genuinely unresolved decisions

Agents own:

- repository investigation
- context routing
- Question generation
- Issue/Epic decomposition
- implementation
- tests
- docs synchronization
- review adjudication
- routine merge/repository maintenance

Escalate only when repository evidence cannot resolve a materially important choice.

---

## Read order — minimum context first

Do not begin by reading the whole repository.

1. Human request / Issue / PR
2. `docs/testing/core-features.md` — resolve the relevant Pack + Flow
3. Relevant `docs/ai/packs/<pack>.md`
4. Relevant project architecture/rules linked by the Pack
5. The relevant Flow document
6. Only affected UI / Validation / DB documents
7. Executable tests for the same Flow IDs
8. Implementation paths listed by the Pack
9. ADRs / historical Questions only when rationale is needed

For a new feature with no matching Flow, inspect project rules and neighboring Packs/Flows before generating Questions. The human does not need to provide a Flow ID.

See `docs/rules/context-routing.md` and `docs/rules/exploration.md`.

## Avoid during initial exploration

Unless the task actually requires them, do not:

- read every file in `docs/rules/`
- grep every Flow document
- read every ADR or historical Question
- treat generated reports/coverage output as primary context
- load unrelated service/language conventions

Use the Index and Pack to route attention.

---

## Source of Truth

### Current behavior — conflict order

When current sources disagree, use this investigation order:

1. **implementation**
2. **executable system/integration contract tests**
3. **current Flow / UI / Validation / DB docs**
4. **generated reports derived from those sources**

This is not permission to silently accept drift. Determine whether code, tests, or docs are stale.

**Never delete or rewrite working implementation/tests solely because a document says something different.** Investigate the conflict first. If intended behavior is still ambiguous, escalate.

### Facts vs history

Current facts belong in:

- implementation
- tests
- Flow / UI / Validation / DB

Decision history belongs in:

- `docs/testing/questions/`
- `docs/adr/`
- Git history

Questions/Answers and ADRs explain **why/how a decision was made**; they do not override current executable truth by themselves.

Do not copy historical debate into current-contract docs.

---

## Required rules

Apply only the relevant rule files:

- Human/AI responsibility boundary: `docs/rules/responsibility-boundary.md`
- Autonomy/continuity: `docs/rules/autonomy-continuity.md`
- Development loop: `docs/rules/development-loop.md`
- Questions: `docs/rules/questions.md`
- Context routing / Packs: `docs/rules/context-routing.md`
- Repository exploration: `docs/rules/exploration.md`
- Current docs / four-document set: `docs/rules/docs-contract.md`
- Testing / Flow IDs: `docs/rules/testing-strategy.md`
- Git / Issue / PR: `docs/rules/git-workflow.md`
- Review adjudication: `docs/rules/review.md`
- Migrations: `docs/rules/migration-safety.md`
- Project architecture/coding: `docs/rules/project-conventions.md`
- Example Laravel: `docs/rules/php-laravel.md`
- Example TypeScript: `docs/rules/typescript-frontend.md`

Sample Laravel/TypeScript architecture is not universal. An adopting repository's explicit project rules override sample architecture.

---

## Question discipline

Do not ask a human about:

- facts discoverable in the repository
- choices already fixed by rules/ADR/current contracts
- style/naming covered by conventions
- ordinary implementation mechanics
- reversible internals with no meaningful external effect

Ask only when multiple materially valid choices remain around:

- product/UX behavior
- public/API/storage contracts
- destructive or compatibility-sensitive data changes
- privacy/security boundaries
- long-term architecture/ownership
- conflicting current sources that cannot be resolved from evidence

Every Question must explain what was investigated, why the ambiguity remains, real options, affected areas, tradeoffs, and an AI recommendation.

---

## Protected boundaries — do not change without an explicit confirmed decision

Unless the Issue/Answers/current contract explicitly require it, do not change:

- public API parameters or response shapes
- business behavior outside Issue scope
- authentication/authorization/CORS/security posture
- destructive data lifecycle semantics
- ownership/dependency direction
- externally observable fallback/error semantics
- architecture/module boundaries
- required audit/history behavior

If such a change becomes necessary, stop at a Question instead of smuggling it into implementation.

---

## Implementation discipline

- Work only within Issue scope.
- Resolve Pack/Flow/context before coding.
- Follow project-specific architecture/language rules before generic ecosystem advice.
- Update implementation, tests, and affected current-contract docs in the same change series.
- Keep Flow SYS/FE IDs synchronized with executable tests.
- Respect Pack scope, non-scope, prohibitions, and parity constraints.
- Do not opportunistically refactor unrelated areas.
- Prefer explicit local code over speculative abstractions.
- For Epic child work, follow the parent/child branch rule.
- Link PRs to Issues and include Pack / Flow / verification evidence.

---

## Review discipline

A review comment is a **claim**, not Source of Truth.

For every finding:

1. inspect the diff and relevant repository evidence
2. classify as **valid**, **false positive**, or **genuinely ambiguous**
3. valid → fix + tests/docs + reply + resolve
4. false positive → reply with concrete repository evidence; do not change correct behavior
5. ambiguous → escalate only that decision with options, impact, and recommendation

Never ask the human merely because a reviewer disagrees.

---

## Completion

A feature is not Done merely because code compiles.

Confirm:

- Issue acceptance criteria satisfied
- no blocking Question remains PENDING
- four-document set is current or explicitly N/A
- Flow matrix matches executable SYS/FE IDs
- required lint/test/project checks pass
- Pack/core-feature index is current
- valid review findings are resolved
- migration/data compatibility obligations are verified
- historical Questions are marked implemented/archive when appropriate

Run the repository's declared completion commands, including the repository survey when docs/structure/Flow mappings changed.
