# Packs

A Pack is an **agent attention-routing manifest** for one bounded feature bundle.

A Pack is not a second specification and not a place to copy Flow/UI/Validation/DB prose.

## A Pack should point to

- scope and explicit non-scope
- Flow IDs
- four-document sets
- implementation paths
- test paths / SYS / FE IDs
- relevant architecture/rules/ADR links
- completion commands/checks
- prohibitions, parity constraints, or easy-to-miss boundaries

## A Pack should not contain

- duplicated API tables already owned by Validation/Flow
- copied UI behavior owned by UI docs
- copied DB schema/persistence rules owned by DB docs
- historical discussion owned by Questions/ADR

## Why Packs exist

Humans should not need to provide a file list or Flow ID for every task.

The core-feature index selects the bundle.  
The Pack routes the agent to the minimum current context.

## Completion

A Pack is not complete because all test IDs are present.

Use [bundle-completion.md](../../testing/bundle-completion.md) for the full Done contract.
