# Human Prompts

These prompts are **entry commands**, not a second rule system.

The Source of Truth for execution is `AGENTS.md` plus the relevant `docs/rules/`, Pack, Flow, tests, and current implementation.

## One-time adoption

Run:

0. **Bootstrap** — inspect the repository and establish project-specific rules/architecture/testing/data/security boundaries.

Bootstrap is not repeated for every feature. It converts an arbitrary repository into one where the normal short loop can operate without humans repeatedly explaining engineering conventions.

## Normal loop

1. Define
2. Decide / answer-loop
3. Implement
4. Review findings
5. Merge

Keep these prompts short.

Do not copy all architecture/testing/docs policy into prompt text; duplicated policy will drift.

Humans may phrase the command naturally. Exact wording is not required if the intent is clear.

The quality target is validated by `docs/testing/protocol-acceptance.md`.
