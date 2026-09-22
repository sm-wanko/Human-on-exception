# Eval 02 — Answer LOOP / Issue quality

## Human prompt

Use `prompts/02-decide.md` after answering a Question in a way that creates one second-order migration or compatibility concern.

## Expected behavior

The agent must:

1. re-read all Answers, not only the newest
2. update Confirmed Decisions
3. detect the second-order consequence
4. ask only the newly material Question if it requires human judgment
5. if all decisions become closed, create implementation Issue(s)
6. choose one Issue vs Epic based on real sequencing/review boundaries
7. include protected/non-scope behavior
8. include Flow/Pack/docs/test/migration impact
9. include dependencies/base-target/merge order when decomposed
10. avoid reopening settled decisions without evidence
