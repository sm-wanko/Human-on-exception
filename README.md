# Human-on-Exception

> **What if the human is the bottleneck?**

Human-on-Exception is a repository protocol for continuously developing software with AI while keeping humans out of routine engineering loops.

The central hypothesis is not that AI is always correct.

It is:

> **Humans should own purpose, authority, and genuinely unresolved decisions. AI should own the engineering work required to turn those decisions into verified repository changes.**

The repository is structured so mistakes can be found and repaired without making a human permanently responsible for search, decomposition, coding, diff review, review triage, docs synchronization, or routine merge coordination.

## Operating model

The canonical responsibility split is defined in:

- [Human / AI Responsibility Boundary](./docs/rules/responsibility-boundary.md)
- [Autonomy and Continuity](./docs/rules/autonomy-continuity.md)
- [Development Loop](./docs/rules/development-loop.md)

### Human owns

- what should exist
- why it matters
- desired product/experience outcome
- non-negotiable boundaries
- Answers to decisions the repository genuinely cannot resolve

### AI owns

- repository search and context recovery
- Questions generation
- Issue/Epic decomposition
- coding and migrations
- tests and current-contract docs
- Pack/index maintenance
- independent review
- reviewer finding adjudication
- correction and re-verification
- routine merge/repository maintenance

### Human should not be required for

- locating files or Flow IDs
- choosing implementation paths
- routine code structure
- reading every diff
- interpreting every AI reviewer comment
- reminding agents to update tests/docs
- deciding routine migration mechanics
- coordinating every child branch/Issue

If normal development repeatedly requires those actions, the protocol is failing.

## The loop

```text
Human intent / why
        ↓
AI search / context recovery
        ↓
AI Questions only for unresolved human-owned decisions
        ↓
Human Answers
        ↓
AI Issue / Epic decomposition
        ↓
AI implementation + migrations + tests + docs
        ↓
Independent AI review
        ↓
AI adjudication
  ├─ valid → fix / verify / resolve
  ├─ false positive → reject with evidence
  └─ genuine ambiguity → Human decision
        ↓
AI resumes / merges / updates repository context
        ↓
Next feature should require equal or less human coordination
```

## Human commands

When adopting the protocol into a repository, run **Bootstrap once**. After that, normal development uses five short commands.

0. **Bootstrap (once)** — derive project-specific architecture, ownership, testing, security, data, and completion rules from repository evidence.
1. **Define** — state what/why/desired experience; AI investigates and creates only necessary Questions.
2. **Decide** — update Answers; AI asks only newly exposed blocking Questions or creates Issues/Epic.
3. **Implement** — AI carries the Issue through code, tests, docs, checks, and PR creation.
4. **Review** — AI independently adjudicates reviewer findings; humans see only genuine ambiguity.
5. **Merge** — AI verifies completion conditions, merges, and updates routing/history.

See [prompts/](./prompts/).

The prompts are intentionally small. They are entry commands, not a second rule system.

## Why this is more than an AI coding template

Human-on-Exception standardizes the repository machinery that makes autonomous work sustainable:

- [responsibility boundary](./docs/rules/responsibility-boundary.md)
- [autonomy continuity](./docs/rules/autonomy-continuity.md)
- [human attention as the scarce resource](./docs/rules/human-attention.md)
- [progressive exploration](./docs/rules/exploration.md)
- [Questions discipline](./docs/rules/questions.md)
- [context routing and Packs](./docs/rules/context-routing.md)
- [four-document current contracts](./docs/rules/docs-contract.md)
- [Flow-linked tests](./docs/rules/testing-strategy.md)
- [Issue / Epic / PR workflow](./docs/rules/git-workflow.md)
- [independent review + adjudication](./docs/rules/review.md)
- [migration safety](./docs/rules/migration-safety.md)
- [project-specific conventions](./docs/rules/project-conventions.md)

The intended outcome is not "AI writes code faster."

It is:

> **Repository growth should not force proportional growth in human coordination.**

## Source of Truth

Current behavior belongs in:

```text
Implementation
    ↓
Executable contract/system tests
    ↓
Flow / UI / Validation / DB current docs
```

Decision history belongs in:

```text
Questions / Answers
ADR
Git history
```

Historical discussion does not override current executable truth by itself.

If current sources conflict, agents investigate the conflict; they do not blindly rewrite working code because a document says otherwise.

## Questions are the human-attention boundary

Questions are not a requirements checklist.

Before asking the human, an agent must search the repository and separate:

- facts already encoded in rules/code/tests/docs
- routine technical choices the AI owns
- genuinely unresolved human-owned decisions

A valid Question explains:

- what was inspected
- why evidence still cannot decide
- materially different options
- consequences / compatibility / risk
- AI recommendation when defensible

After Answers, AI re-evaluates second-order consequences and loops only when a new human decision is truly required.

See [questions.md](./docs/rules/questions.md).

## Architecture is project-specific

**The Laravel + TypeScript code in this repository is only a runnable example. It is not the Human-on-Exception architecture.**

Each adopting repository should define an architecture appropriate to its own:

- existing codebase
- size and complexity
- deployment model
- performance/operational constraints
- maintenance horizon
- team/agent scale

A small project may need fewer layers.
A large project may need stronger dependency guards or multiple services.

The rule is:

> **Choose an architecture that fits the project, then encode it clearly enough that agents do not reinvent it.**

Use [00-bootstrap](./prompts/00-bootstrap.md) to establish these rules from repository evidence.

## Example implementation

The sample Task CRUD demonstrates the protocol with Laravel + TypeScript:

- [core feature index](./docs/testing/core-features.md)
- [Pack](./docs/ai/packs/task-crud.md)
- [Questions](./docs/testing/questions/task-crud.md)
- [Flow](./docs/flow/task-crud.md)
- [UI](./docs/ui/task-crud.md)
- [Validation](./docs/validation/task-crud.md)
- [DB](./docs/db/task-crud.md)
- [backend](./backend/)
- [frontend](./frontend/)

The sample backend deliberately uses a right-sized architecture:

```text
Laravel HTTP
    ↓
Application use cases
    ↓
Application ports / Quick+Detail read models
    ↑
Eloquent Infrastructure
```

There is no ceremony-only Domain layer for trivial CRUD.

## Mechanical verification

```bash
python scripts/repo_survey.py
```

CI currently verifies:

- Flow ↔ UI/Validation/DB structure
- Flow ↔ Pack/core index
- SYS/FE IDs ↔ executable source references
- four-document Flow ID consistency
- local Markdown links
- Laravel Feature tests
- TypeScript typecheck
- frontend contract tests

These checks make drift observable. They do not define the operating philosophy.

## Behavioral evaluation

Prompt-level evaluations exist under [docs/testing/prompt-evals/](./docs/testing/prompt-evals/) and [protocol-acceptance.md](./docs/testing/protocol-acceptance.md).

Long-running evidence for the actual hypothesis is described in [operating-evidence.md](./docs/testing/operating-evidence.md).

They are evidence that the operating model is being followed, not the purpose of the project.

The stronger test is long-term:

- does the human need to identify files less often?
- do settled decisions stop being re-asked?
- can AI review AI without human arbitration?
- can repository size grow without requiring mandatory human diff review?
- does human attention remain concentrated on new intent and exceptional decisions?

## Repository map

```text
AGENTS.md                         Agent operating contract
prompts/                          Bootstrap + five normal human commands

docs/rules/responsibility-boundary.md
docs/rules/autonomy-continuity.md
docs/rules/development-loop.md
docs/rules/                        Search, Questions, docs, tests, review, Git, migration rules

docs/testing/core-features.md       Context-routing index
docs/ai/packs/                      Feature attention-routing manifests
docs/flow/                          Current behavior + test matrices
docs/ui/                            Current UI contract
docs/validation/                    Current input/auth/error contract
docs/db/                            Current persistence/Tx contract
docs/testing/questions/             Decision history
docs/adr/                           Durable rationale

backend/                            Runnable Laravel example
frontend/                           Runnable TypeScript/React example
.cursor/BUGBOT.md                   Independent reviewer role example
scripts/repo_survey.py              Repository contract survey
.github/                            Issue/PR templates + CI
```

## Origin

This protocol was extracted from a real solo repository that evolved by repeatedly removing human bottlenecks from context recovery, Issue decomposition, implementation, review, and review triage.

The core principle is:

> **Do not make the agent infallible. Make mistakes observable and recoverable without requiring continuous human supervision.**

## Status

Experimental.

Opinionated about the **human/AI responsibility model and development loop**.

Application architecture is replaceable.
