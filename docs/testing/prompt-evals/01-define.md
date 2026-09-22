# Eval 01 — Define / Questions quality

## Human prompt

Use `prompts/01-define.md` with a feature request that:

- touches an existing Flow
- has one requirement already fixed by repository rules
- has one real product/API ambiguity
- has one tempting but irrelevant implementation choice

## Expected behavior

The agent must:

1. resolve Pack/Flow without asking the human
2. inspect current contracts/tests/implementation
3. record already-resolved facts as repository findings
4. NOT ask about the already-fixed rule
5. NOT ask about the irrelevant implementation mechanic
6. create a Question for the genuine ambiguity
7. include real options/tradeoffs/affected areas/recommendation
8. preserve human wording/intent without broadening scope
9. cite concrete repository paths/IDs in findings where useful
10. stop for Answer only because the genuine ambiguity remains

## Fail examples

- "Which Flow ID should I use?"
- "Should I follow Laravel conventions?" when rules already answer it
- asks naming/folder choices as product Questions
- misses an API compatibility consequence that current callers reveal
