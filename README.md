# Human-on-Exception

> **What if the human is the bottleneck?**

Human-on-Exception is a repository protocol for AI-driven software development built around one simple responsibility split:

```text
Human wants something
        ↓
AI investigates the repository and creates Questions
        ↓
Human answers only the unresolved decisions
        ↓
AI creates Issues, implements, updates feature docs/tests, and opens PRs
```

That is the core.

The goal is not to prove that AI never makes mistakes.

The goal is to prove that a human does not need to remain the permanent coordinator of search, decomposition, coding, documentation, testing, or routine review work.

## Responsibilities

The canonical boundary is defined in [docs/rules/responsibility-boundary.md](./docs/rules/responsibility-boundary.md).

### Human

Humans own:

- what should exist
- why it matters
- desired product/experience outcome
- non-negotiable boundaries
- Answers to decisions the repository cannot resolve

### AI

AI owns:

- repository search and context recovery
- deciding which existing Flow/Pack/rules apply
- Questions generation
- Issue/Epic decomposition
- implementation
- migrations and routine technical mechanics
- tests
- Flow/UI/Validation/DB current docs
- Pack/index maintenance
- PR creation
- independent review and finding adjudication
- routine merge preparation

A human should not need to tell the AI which files to inspect, which Flow ID to use, how to split routine work, or whether every review comment is correct.

## The five human prompts

See [prompts/](./prompts/).

1. **Define** — describe the feature / why / desired experience.
2. **Decide** — update Answers; AI either asks the next real Question or creates Issues.
3. **Implement** — AI implements the Issue through code, tests, docs, checks, and PR.
4. **Review** — AI validates reviewer findings, fixes valid ones, rejects false positives, and asks the human only on genuine ambiguity.
5. **Merge** — AI verifies completion conditions and prepares/completes the merge flow.

The first three contain the essential loop:

> **Human intent → AI Questions → Human Answers → AI implementation + feature overview + PR**

The remaining prompts allow the same responsibility model to continue after the PR exists.

## Why the repository structure matters

Short prompts only work when the repository carries enough context for AI to investigate autonomously.

The main rails are:

- [AGENTS.md](./AGENTS.md) — operating contract and Source of Truth rules
- [Questions rule](./docs/rules/questions.md) — what AI may ask a human
- [Exploration rule](./docs/rules/exploration.md) — how AI finds the right context without asking for file paths
- [Context routing / Packs](./docs/rules/context-routing.md) — feature-level attention routing
- [Docs contract](./docs/rules/docs-contract.md) — Flow / UI / Validation / DB ownership
- [Testing strategy](./docs/rules/testing-strategy.md) — Flow-linked verification
- [Review rule](./docs/rules/review.md) — reviewer finding adjudication
- [Git workflow](./docs/rules/git-workflow.md) — Issue / Epic / PR boundaries
- [Project conventions](./docs/rules/project-conventions.md) — project-specific architecture and coding rules

These rules exist so the human does not have to repeat engineering context in every prompt.

## Source of Truth

For current behavior, agents investigate in this order:

```text
implementation
→ executable system/integration contract tests
→ current Flow / UI / Validation / DB docs
```

Questions and ADRs are decision history/rationale, not a substitute for current executable truth.

If sources conflict, AI investigates the conflict instead of blindly rewriting working code or asking the human to sort out discoverable facts.

## Questions

Questions are the human-attention boundary.

AI must first inspect the repository and separate:

- what is already decided
- what is routine implementation detail
- what genuinely requires human judgment

A Question is valid only when multiple materially valid outcomes remain and the repository cannot decide between them.

After the human updates Answers, AI re-evaluates consequences. If nothing important remains ambiguous, it stops asking and creates the implementation Issue(s).

## Feature overview docs

The sample follows the same four-document split used by the protocol:

- **Flow** — scope, path, service/API order, test matrix
- **UI** — visible behavior and operations
- **Validation** — input/auth/error contract
- **DB** — persistence/transaction contract

They are current behavior docs, not decision-history dumps.

Questions preserve the decision process; ADRs preserve durable rationale when needed.

## Architecture is replaceable

The Laravel + TypeScript sample is only an example.

Human-on-Exception does not require Laravel, React, Clean Architecture, repositories, or this exact directory layout.

Each real project should encode its own architecture and prohibitions in project rules.

The important property is not a specific architecture.

It is:

> **AI can discover the architecture from the repository and follow it without requiring the human to restate it every time.**

## Example

The included Task CRUD demonstrates:

- Questions → Answers
- Pack / Flow routing
- Laravel application/infrastructure separation
- Quick vs Detail read models
- TypeScript feature structure
- Flow-linked backend/frontend tests
- Flow/UI/Validation/DB docs

See:

- [Pack](./docs/ai/packs/task-crud.md)
- [Questions](./docs/testing/questions/task-crud.md)
- [Flow](./docs/flow/task-crud.md)
- [UI](./docs/ui/task-crud.md)
- [Validation](./docs/validation/task-crud.md)
- [DB](./docs/db/task-crud.md)

## Verification

```bash
python scripts/repo_survey.py
```

CI verifies the sample implementation and the repository contract, including Flow/Pack/docs/test traceability.

Those checks support the loop; they are not the point of the project.

## Origin

This protocol was extracted from Paw-Pads after repeatedly removing human work from:

- context recovery
- Questions generation
- Issue decomposition
- implementation
- documentation synchronization
- review triage

The core idea is intentionally small:

> **Humans decide what and why. AI investigates, asks only what it cannot decide, then builds.**

If humans must continuously tell the AI where to look, how to code, what review findings mean, or what docs to update, the human is still the bottleneck.
