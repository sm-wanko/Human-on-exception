# Human-on-Exception

> **What if humans stopped living inside the implementation and review loop?**

Human-on-Exception is a repository architecture for AI-run software development.

The working hypothesis is simple:

- Humans own **intent, rationale, and boundaries**.
- Agents handle **investigation, decomposition, implementation, testing, review, correction, and repository maintenance**.
- Humans are escalated only when the repository cannot resolve a real ambiguity.

This is not a prompt collection for generating code faster. It is a way to structure a repository so agents can keep working without repeatedly asking a human to rediscover context.

## The loop

```text
Human intent
   ↓
AI resolves Pack / Flow / Rules / ADR / implementation context
   ↓
AI generates only unresolved Questions
   ↓
Human answers boundary decisions
   ↓
AI re-checks for ambiguity
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
          ├─ valid → fix + test + resolve
          ├─ false positive → reply with evidence
          └─ genuinely ambiguous → human escalation
                   ↓
                 merge
```

## Five human commands

The normal workflow is intentionally small.

1. **Define** — "I want to implement this. Generate the Questions required before implementation."
2. **Decide** — "I updated the Answers. Ask again only if something remains unclear; otherwise create the Issues."
3. **Implement** — "Work according to the Issue. Create branches and PRs according to the repository rules."
4. **Review** — "PR #123 has review comments. Fix valid findings, reject false positives with evidence, escalate only unresolved ambiguity."
5. **Merge** — "Merge completed work and update the development branch."

See [`prompts/`](./prompts/) for reusable versions.

## Why Questions exist

Questions are not a requirements dump and they are not permission requests for every implementation detail.

They are an **attention filter for expensive human judgment**.

An agent should ask only when the decision cannot be resolved from the repository and materially affects product behavior, contracts, risk, irreversible data changes, or architectural boundaries.

Before asking, the agent must search the relevant rules, ADRs, current implementation, flows, and tests.

See [`docs/rules/questions.md`](./docs/rules/questions.md).

## Repository map

```text
AGENTS.md                    Agent operating contract
prompts/                     Five human entry commands
docs/rules/                  Cross-cutting development rules
docs/templates/              Reusable Flow/UI/Validation/DB/ADR/Questions templates
docs/adr/                    Durable rationale for decisions
docs/examples/task-crud/     Example docs for one complete CRUD flow
examples/task-crud/          Small runnable CRUD example
.github/ISSUE_TEMPLATE/      Issue/Epic conventions
```

## Documentation roles

The repository separates current behavior from decision history.

```text
Questions / Answers  = decision process
ADR                  = durable rationale when the why must survive
Flow                 = user/system path and test matrix
UI                   = visible behavior and operations
Validation           = input/auth/error contract
DB                   = persistence/transaction contract
Implementation       = executable truth
Tests                = executable verification
```

Old Questions must not silently become the current specification. After implementation, the durable result belongs in Flow/UI/Validation/DB and, where necessary, an ADR.

## Example: Task CRUD

`examples/task-crud/` is deliberately boring. The point is not the CRUD itself; the point is that one tiny feature demonstrates the whole operating model.

Related docs:

- [`docs/examples/task-crud/questions.md`](./docs/examples/task-crud/questions.md)
- [`docs/examples/task-crud/flow.md`](./docs/examples/task-crud/flow.md)
- [`docs/examples/task-crud/ui.md`](./docs/examples/task-crud/ui.md)
- [`docs/examples/task-crud/validation.md`](./docs/examples/task-crud/validation.md)
- [`docs/examples/task-crud/db.md`](./docs/examples/task-crud/db.md)

## Origin

This structure was extracted from a real solo hobby repository that evolved under continuous GPT/Cursor-assisted development. The workflow was not designed from a blank-slate methodology document; it emerged by repeatedly removing human bottlenecks from implementation, review, coordination, and context recovery.

The core principle is:

> **Do not make the agent infallible. Make mistakes observable, reviewable, and difficult to keep latent.**

## Status

Experimental. The architecture is intentionally opinionated, but the application/domain layer is replaceable.
