# Human Prompts

These prompts are **entry commands**, not a second rule system.

Execution is governed by `AGENTS.md`, especially the canonical [Human / AI Responsibility Boundary](../docs/rules/responsibility-boundary.md).

## Human input should stay small

The human should normally provide only:

- intent / what
- why / desired outcome
- non-negotiable boundaries
- Answers to genuine Questions

The human should not need to provide:

- Flow IDs
- file paths
- implementation decomposition
- test plans
- routine review verdicts
- migration mechanics

If a prompt routinely requires those, repository autonomy is incomplete.

## One-time adoption

0. **Bootstrap** — inspect the repository and establish project-specific rules/architecture/testing/data/security boundaries.

Bootstrap exists so humans do not have to repeat engineering conventions on every feature.

## Normal loop

1. Define
2. Decide / answer-loop
3. Implement
4. Review findings
5. Merge

Humans may phrase these naturally. Exact wording is not required if intent is clear.

Keep prompts short; keep engineering policy in repository Source of Truth.
