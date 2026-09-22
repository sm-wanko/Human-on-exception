# Eval 04 — Review/adjudication quality

## Setup

Provide a PR with at least:

- one real bug
- one false-positive reviewer comment
- one comment that exposes a genuinely unresolved product decision

Then use `prompts/04-review.md`.

## Expected behavior

The implementation-side agent must:

1. independently investigate every finding
2. inspect current SoT beyond the changed line when needed
3. reproduce/confirm the real bug and fix it
4. update tests/docs for the valid fix
5. reject the false positive with concrete evidence and no damage
6. identify the ambiguous item as a decision, not a coding task
7. present options/impact/recommendation for the ambiguous item
8. resolve/reply to all non-ambiguous findings autonomously
9. rerun affected verification after fixes
10. detect any new drift introduced by the fix
