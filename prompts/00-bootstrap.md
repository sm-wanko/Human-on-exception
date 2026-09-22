# 00 — Bootstrap Repository Rules

Use this once when adopting Human-on-Exception into an existing or new repository.

My goal is to make this repository autonomous under the Human-on-Exception loop.

Follow `AGENTS.md`.

Inspect the repository before asking me anything:

- current languages/frameworks/package managers
- directory/module/layer structure
- dependency direction and ownership
- API/error conventions
- persistence, migrations, seed/master ownership
- authentication/security/audit behavior
- external services, jobs, cache/event patterns
- frontend state/router/rendering conventions
- existing tests/CI/lint/build commands
- existing ADRs/docs/contributor rules
- recurring patterns and explicit prohibitions already encoded in code/tests

Then:

1. separate **observed current conventions** from **choices that are genuinely undecided**
2. create/update project-specific architecture and rule files
3. create Questions only for long-lived boundaries the repository cannot resolve from evidence
4. do not import the sample Laravel/TypeScript architecture unless it actually fits
5. define concrete completion commands and test locations
6. define protected boundaries and Source-of-Truth behavior
7. establish the core-feature/Pack/Flow routing skeleton appropriate to the repository
8. run the repository survey/checks

Stop for human input only if unresolved architecture/data/security/product boundaries remain.

After bootstrap is confirmed, normal feature work should use prompts 01–05 without requiring humans to repeat repository conventions.
