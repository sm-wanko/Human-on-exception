# Human-on-Exception

> **If AI keeps getting better, how much engineering work actually still needs a human?**  
> This repository takes that question seriously and draws an explicit boundary between human authority and AI execution.

> **Humans decide intent and boundaries. AI owns execution.**

Humans own **Intent / Scope / Answers / Risk acceptance** and the semantic boundaries that define product meaning. AI owns investigation, design, Issue creation, implementation, tests, docs, PR creation, independent review handling, fixes, and re-verification.

Human coding, code reading, and line-by-line code review are not normal required gates. The "Exception" is a decision AI does **not** have authority to make—not an ordinary bug, failing test, or review fix. The authoritative workflow contract is [docs/rules/ai-workflow.md](./docs/rules/ai-workflow.md).

## What is in this repository

- **Execution contract** — responsibility boundaries, Questions, Issues, implementation, and completion
- **Questions / Answers** — AI investigates current state and asks only for decisions requiring human authority
- **Source of Truth rules** — distinguish current-state facts from an agreed target contract
- **Independent AI review** — a separate context verifies AC, SoT, diff, tests, and docs
- **4-point docs** — flow / ui / validation / db as a human-readable current feature overview and verification surface
- **Executable example** — a minimal Laravel / Next.js Task CRUD

Start with README → [AI execution contract](./docs/rules/ai-workflow.md) → [Questions template](./docs/templates/questions.md) → [Task CRUD example](./docs/testing/questions/task-crud.md) → [Independent AI review](./docs/rules/ai-review.md).

## Human prompts

Optional bootstrap for a new product: [0. Greenfield bootstrap](./prompts/00-greenfield.md). The normal development loop remains the five entry/resume prompts below.

1. [Define Questions](./prompts/01-define.md) — [existing repo](./prompts/01-define-existing.md) / [greenfield](./prompts/01-define-greenfield.md)
2. [Apply Answers / Create Issue](./prompts/02-decide.md)
3. [Implement Issue / PR](./prompts/03-implement.md)
4. [Resolve PR review](./prompts/04-review.md)
5. [Merge / update target branch](./prompts/05-merge.md)

Normal flow:

```text
Human: I want this feature.
  ↓
AI: investigate the current contract, or design from repo rules in greenfield mode, then create Questions
  ↓
Human: answer only the decisions
  ↓
AI: if no blocker remains, create the Issue and own implementation, tests, 4-point docs, and PR
  ↓
Independent-context AI reviews the PR
  ↓
Implementation AI classifies findings against SoT, fixes valid ones, and returns only decision exceptions to the human
```

## Anti-misreading principles

- Do not infer product purpose from implementation size, file count, or familiar product categories. Read concept, human answers, and accepted decisions first.
- Authentication actor, operator, owner/manager, experience/record subject, and search/decision actor may differ. FK/login structure alone does not define the domain protagonist.
- A bulk UI operation does not imply one persisted/editable/unique domain record.
- Do not promote internal scores, candidates, references, or inferences into confirmed facts or recommendations unless the agreed meaning allows it.
- MVP does not mean minimum file count. Semantic distinctions required to test the value hypothesis may be part of the MVP.

## Quality model

- **concept**: purpose and core concepts
- **ADR**: durable adopted reasons
- **Policy**: repeatable agreed criteria AI may apply
- **Questions**: evidence, options, recommendations, unresolved items, answers, revision history
- **Issue**: agreed answers converted into observable acceptance criteria and mapped to Flow/tests/docs
- **Execution**: implementation, verification, self-review, and evidence are AI-owned
- **Independent review**: Codex / Cursor Bugbot / Claude or another separate-context reviewer
- **Completion**: required checks pass, valid findings are resolved, and AC are evidenced

[Questions template](./docs/templates/questions.md) · [workflow conformance](./docs/testing/workflow-conformance.md) · [AI review](./docs/rules/ai-review.md)

The 4-point set is a human-readable current feature overview maintained by AI and also a verification surface for implementation/tests. Human code or document approval is not a normal gate.

The five prompts are entry/resume points, not five human approval gates. Once answers and permissions are sufficient, AI continues authorized stages.

## Adoption

Human-on-Exception is not limited to greenfield repositories. Existing codebases can adopt the workflow by first letting AI reconstruct the current contracts from implementation and tests, then create or align the 4-point docs, concept, Questions, ADR, and Policy only where they are needed. No greenfield rewrite is required.

For a new product, run `make greenfield DRY_RUN=1` first. After confirming the plan, run `make greenfield CONFIRM=1`. The executable example is archived locally under gitignored `.trash/`, active references are reset to zero-product state, and the workflow/rules/templates/application skeleton remain. Then begin with [1B. Greenfield](./prompts/01-define-greenfield.md).

## Adapting the harness to other stacks

Human-on-Exception is **not tied to Laravel or Next.js**. The Laravel / Next.js implementation and coding rules in this repository are an executable sample showing how stack-specific rules participate in the harness.

When adopting the workflow in another language, framework, or architecture, keep the **responsibility of each rule**, not the sample technology itself:

- define a small, always-read rule for each implementation area (for example backend / frontend / data / infrastructure)
- keep detailed conventions separate and load them only when the touched area needs them
- state layer ownership, transaction / concurrency expectations, validation boundaries, test strategy, and completion commands for that stack
- define where domain meaning is allowed to live so agents do not duplicate business semantics across controllers, components, hooks, serializers, or equivalent layers
- map the repository's actual verification commands into Issues / PRs so an agent can prove completion without inventing ad-hoc checks

For example, a Go, Rust, Python, Java, mobile, or monorepo adoption should replace the sample Laravel / Next.js coding rules with rules that describe that repository's real architecture and verification surface. Do **not** copy framework-specific conventions merely because they exist in this sample.

The portable part of this repository is the execution model:

```text
human authority
  → semantic Questions / Answers
  → observable Issue acceptance criteria
  → scoped agent execution
  → repository-native verification
  → independent-context review
  → finding classification / fix / re-verification
```

## Observed behavior

This repository is developed by running the workflow itself. In recent trials:

- a deliberately vague greenfield reservation-system request was investigated into a bounded set of human semantic decisions instead of framework / file-layout questions
- an Issue implementation produced a cross-cutting backend / frontend / database / test / CI / docs PR with self-review and verification evidence
- an independent Codex review of a CI-green implementation still found substantive issues including a concurrency race, frontend/backend validation mismatch, UI state inconsistency, and missing audit evidence

These are observations from specific runs, not guarantees of defect-free autonomous development. The point of the harness is to make authority, evidence, failures, and unresolved decisions explicit enough for another agent—or a human—to inspect.

## Local startup

Docker Compose V2:

```bash
make up
```

- Frontend: http://localhost:3000/
- Task list: http://localhost:3000/tasks/
- Backend health: http://localhost:8080/up
- Backend API: http://localhost:8080/api/tasks
- PostgreSQL: localhost:5432

Stop:

```bash
make down
```

Rebuild:

```bash
make build
make up
```

Backend startup applies DB migrations automatically. `make init-db` / `make reset-db` are also available.

Create a Task:

```bash
curl -X POST http://localhost:8080/api/tasks \
  -H 'Content-Type: application/json' \
  -d '{"title":"Try Human-on-Exception","description":"Laravel sample"}'
```

## Development commands

```bash
make lint
make test
make survey
make docs
```

## Source of Truth

When current-state sources conflict, follow [AGENTS.md](./AGENTS.md):

```text
implementation → system test → docs/flow → coverage/*
```

Current behavior is code + flow / ui / validation / db. Purpose/core concepts live in `docs/concept/`; decision history in `docs/testing/questions/`; active design decisions in `docs/testing/adr/`; repeatable criteria in `docs/testing/policy/`.

## Sample

The repository includes one minimal sample bundle: `EXAMPLE_TASK_CRUD`.

- Pack: [docs/ai/packs/task-crud.md](./docs/ai/packs/task-crud.md)
- Flow: [docs/flow/タスクCRUD.md](./docs/flow/タスクCRUD.md)
- Questions: [docs/testing/questions/task-crud.md](./docs/testing/questions/task-crud.md)
- Backend: `apps/backend/`
- Frontend: `apps/frontend/`
