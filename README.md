# Human-on-Exception

> **What if humans stopped living inside the implementation and review loop?**

Human-on-Exception is a repository protocol for AI-run software development.

The hypothesis:

- Humans own **intent, rationale, and boundaries**.
- Agents handle **investigation, decomposition, implementation, testing, review, correction, and repository maintenance**.
- Humans are escalated only when repository evidence cannot resolve a real ambiguity.

This is not primarily a coding template. It is a way to structure repository context so agents can work without repeatedly asking humans to rediscover decisions.

## The loop

```text
Human intent
   ↓
AI resolves Index → Pack → Flow → rules → current contracts → tests → implementation
   ↓
AI generates only unresolved Questions
   ↓
Human answers boundary decisions
   ↓
AI re-checks consequences
   ├─ ambiguous → add Questions
   └─ clear → create Issue / Epic + child Issues
                   ↓
              implement
                   ↓
                  PR
                   ↓
          independent AI review
                   ↓
        implementation AI adjudicates
          ├─ valid → fix + tests/docs + resolve
          ├─ false positive → reject with evidence
          └─ genuinely ambiguous → human escalation
                   ↓
                 merge
```

## Human commands

For an existing/new repository, run **Bootstrap once** to encode project-specific conventions. After that, normal development uses the same five short commands.

0. **Bootstrap (once)** — agent inspects the repository and establishes project-specific architecture/data/testing/security conventions; unresolved durable boundaries become Questions.\n1. **Define** — describe what/why/desired experience; agent investigates and generates only necessary Questions.\n2. **Decide** — update Answers; agent loops only if new material ambiguity appears, otherwise creates Issues/Epic.\n3. **Implement** — agent works Issue-by-Issue, preserving rules/contracts and opening linked PRs.\n4. **Review** — agent adjudicates reviewer findings rather than blindly accepting them.\n5. **Merge** — agent verifies contracts/checks, merges, synchronizes branches and indexes.

Reusable prompts live in [`prompts/`](./prompts/).

## What this repository standardizes

Human-on-Exception standardizes the **development protocol**:

- context routing with Index / Pack / Flow
- Questions / Answers as a human-attention boundary
- Flow / UI / Validation / DB as current feature contracts
- stable test IDs
- Issue / Epic / PR traceability
- independent review + implementation-side adjudication
- human escalation only for unresolved decisions
- repository surveys/checks that make drift observable

The prompts are intentionally small. Quality comes from the repository rules behind them.

## Architecture is project-specific

**The Laravel + TypeScript architecture in this repository is only a sample. It is not the Human-on-Exception architecture.**

Every adopting repository should define architecture and coding rules appropriate to its own:

- existing codebase
- system size and complexity
- team/agent scale
- performance and operational constraints
- deployment model
- maintenance horizon

A small project may need fewer layers than this sample.  
A large project may need stricter module boundaries, generated contracts, dependency checks, or multiple services.

Do not copy the example mechanically.

The important rule is:

> **Choose an architecture that fits the project, then encode that architecture clearly enough that agents do not have to reinvent it.**

See:

- [project conventions](./docs/rules/project-conventions.md)
- [sample backend architecture](./docs/architecture/backend.md)
- [sample frontend architecture](./docs/architecture/frontend.md)
- [sample dependency rules](./docs/architecture/dependency-rules.md)

## What makes this more than prompts

- [context routing and Packs](./docs/rules/context-routing.md)\n- [progressive repository exploration](./docs/rules/exploration.md)
- [Questions discipline](./docs/rules/questions.md)
- [four-document current contract](./docs/rules/docs-contract.md)
- [Flow-linked test IDs and vertical testing](./docs/rules/testing-strategy.md)
- [Issue/PR/Epic branching](./docs/rules/git-workflow.md)
- [independent review + adjudication](./docs/rules/review.md)
- [migration safety](./docs/rules/migration-safety.md)
- [project-specific conventions](./docs/rules/project-conventions.md)

Without project-specific rules, this starter can reproduce the **workflow**, but not the architectural/domain quality of an existing mature repository. Use [00-bootstrap](./prompts/00-bootstrap.md) once to derive and encode those project-specific rules from repository evidence before expecting Paw-like autonomy.

## Repository map

```text
AGENTS.md                     Agent operating contract
prompts/                      One-time bootstrap + five normal human commands

docs/testing/core-features.md Context-routing index
docs/ai/packs/                Feature-bundle manifests
docs/flow/                    Current behavior + test matrices
docs/ui/                      Current UI contract
docs/validation/              Current input/auth/error contract
docs/db/                      Current persistence/Tx contract
docs/testing/questions/       Decision history
docs/adr/                     Durable rationale
docs/rules/                   Cross-cutting + project rules
docs/architecture/            Example/adopted architecture boundaries
docs/templates/               Reusable templates

backend/                      Laravel reference implementation fragments
frontend/                     TypeScript/React reference implementation
.cursor/BUGBOT.md             Independent reviewer role example
scripts/repo_survey.py        Repository contract survey
.github/                      Issue/PR templates + CI
```

## Questions are an attention filter

Questions are not a requirements dump and not permission requests for implementation trivia.

Before asking, an agent must inspect relevant:

- project rules / architecture
- Packs and current Flow contracts
- tests
- implementation
- ADRs / historical Questions when rationale is needed

A Question is emitted only when a remaining choice materially affects product behavior, contract, risk, irreversible data change, privacy/security, or long-term architecture.

See [`docs/rules/questions.md`](./docs/rules/questions.md).\n\nFor a stricter self-check of whether an adopting repository can reproduce the intended behavior from the short prompts, use [`docs/testing/protocol-acceptance.md`](./docs/testing/protocol-acceptance.md).

## Current contract vs history

```text
Questions / Answers = decision process
ADR                 = durable rationale
Flow                = user/system path + test matrix
UI                  = visible behavior and operations
Validation          = input/auth/error contract
DB                  = persistence/transaction contract
Implementation      = executable truth
Tests               = executable verification
```

After implementation, current behavior belongs in Flow/UI/Validation/DB. Historical debate stays in Questions/ADR/Git.

## Example: Task CRUD

The example demonstrates the repository chain using Laravel + TypeScript:

- [core feature index](./docs/testing/core-features.md)
- [Pack](./docs/ai/packs/task-crud.md)
- [Questions](./docs/testing/questions/task-crud.md)
- [Flow](./docs/flow/task-crud.md)
- [UI](./docs/ui/task-crud.md)
- [Validation](./docs/validation/task-crud.md)
- [DB](./docs/db/task-crud.md)
- [backend reference](./backend/)
- [frontend reference](./frontend/)

The backend example uses a right-sized layered structure:

```text
Laravel HTTP
    ↓
Application use cases
    ↓
Application Port / Quick+Detail read models
    ↑
Eloquent Infrastructure
```

There is intentionally no ceremony-only Domain layer for the trivial CRUD. A real project should add one only when real domain behavior justifies it.

The sample directories are intentionally small, but their Laravel Feature tests and TypeScript contract tests are runnable in CI. The portable artifact is still the repository protocol and its contracts, not this sample architecture.

## Repository survey

```bash
python scripts/repo_survey.py
```

The CI survey currently checks, among other things:

- Flow → UI/Validation/DB peers
- Flow → Pack
- Flow SYS/FE IDs ↔ executable source references\n- Flow → Pack/core index consistency\n- four-document Flow ID consistency\n- local Markdown link integrity

Real projects should extend this with their own lint, architecture, dependency, migration, and test commands.

## Origin

This structure was extracted from a real solo hobby repository that evolved under continuous GPT/Cursor-assisted development. It emerged by repeatedly removing human bottlenecks from context recovery, Issue decomposition, implementation, review, and review triage.

> **Do not make the agent infallible. Make mistakes observable, reviewable, and difficult to keep latent.**

## Status

Experimental and intentionally opinionated about the **development loop**.

Application architecture is intentionally replaceable.
