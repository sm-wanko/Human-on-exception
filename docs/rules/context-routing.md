# Context Routing

## Goal

Humans should not have to remember Flow IDs or list files for the agent. The repository must let the agent resolve the smallest relevant context bundle itself.

## Read order

For a feature task, read in this order:

1. human request / Issue / PR
2. `docs/testing/core-features.md` to resolve Pack + Flow
3. relevant project architecture/rules linked by the Pack
4. the relevant `docs/ai/packs/<pack>.md`
5. the feature's Flow document
6. only affected UI/Validation/DB documents
7. executable tests for the same Flow IDs
8. implementation paths listed by the Pack
9. only additional language/domain rules needed for touched code
10. relevant ADRs / historical Questions only when rationale is needed

## Avoid context flooding

Do not begin by reading every rule, every Flow, or the whole repository.

Packs are attention-routing manifests. They should list:

- scope and explicit non-scope
- Flow IDs
- current four-document sets
- implementation paths
- test paths
- relevant architecture/rule/ADR links
- completion commands/checks
- domain-specific prohibitions or parity constraints

## New feature with no Pack/Flow

When no matching Flow exists:

1. inspect project architecture/rules and neighboring patterns
2. investigate existing implementation/tests that own similar responsibilities
3. create Questions only for unresolved product/boundary decisions
4. after Answers are clear, assign a new Flow ID
5. create the four-document set
6. create/update a Pack and the core-feature index

The human does not need to invent the Flow ID unless they want to.
