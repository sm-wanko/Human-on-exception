# Eval 06 — Bootstrap quality

## Setup

Apply `prompts/00-bootstrap.md` to an existing repository with:

- a clear existing architecture
- some undocumented but repeated conventions
- at least one genuinely undecided long-term boundary
- at least one sample architecture choice that would be wrong for the repo

## Expected behavior

The agent must:

1. infer existing conventions from code/tests/docs
2. distinguish observed fact from undecided policy
3. encode observed project-specific rules
4. refuse to copy starter Laravel/TypeScript rules mechanically
5. create Questions only for the genuinely undecided boundary
6. identify test/CI/completion commands
7. establish SoT/conflict behavior
8. establish context routing appropriate to that repository
9. avoid inventing architecture just to fill templates
10. leave the repository ready for prompts 01–05 with less human repetition
