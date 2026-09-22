# Human Prompts

These prompts are entry commands, not a second rule system.

Execution is governed by `AGENTS.md` and the repository rules.

## Core responsibility split

The human provides:

- what should be built
- why / desired outcome
- non-negotiable boundaries
- Answers to genuine Questions

The AI provides:

- repository investigation
- Questions
- Issue / Epic decomposition
- implementation
- current feature docs
- tests
- PR creation
- review handling
- merge preparation

The human should not need to provide Flow IDs, file paths, implementation decomposition, test plans, or routine review verdicts.

## Normal loop

1. Define
2. Decide / answer-loop
3. Implement
4. Review findings
5. Merge

The first three prompts are the core loop:

```text
Human wants something
→ AI investigates and asks Questions
→ Human answers
→ AI implements and creates docs/tests/PR
```

Prompts 04 and 05 continue the same responsibility model after the PR exists.

Keep prompts short; keep engineering policy in repository Source of Truth.
