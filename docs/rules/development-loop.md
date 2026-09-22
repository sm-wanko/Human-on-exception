# Development Loop

## Normal path

1. Human provides intent.
2. Agent resolves repository context and creates Questions only where needed.
3. Human answers boundary decisions.
4. Agent repeats Question analysis until no material ambiguity remains.
5. Agent creates Issue(s).
6. Agent implements Issue(s), tests, and contract docs.
7. Agent opens PR(s) linked to Issue(s).
8. Independent reviewer(s) inspect PR(s).
9. Implementation agent adjudicates findings.
10. Human is involved only for genuinely unresolved decisions.
11. Agent merges and synchronizes the development branch when merge conditions are satisfied.

## Stop conditions

### Define / Questions
Stop and ask the human only when product/boundary ambiguity remains after repository investigation.

### Issue creation
Do not create implementation Issues while a blocking human decision is still PENDING.

### Implementation
Do not expand scope beyond the Issue merely because nearby code could be improved.

### Review
Do not blindly implement reviewer suggestions. Validate each claim against the repository.

### Merge
Do not merge while required CI is failing or a valid review finding remains unresolved.

## Human responsibility

Humans own:

- what should exist
- why it matters
- product/experience direction
- non-negotiable boundaries
- decisions where repository evidence cannot choose safely

Humans are not required to own:

- code generation
- routine decomposition
- routine Issue authoring
- routine code review
- review-comment triage
- migration mechanics
- test implementation
- documentation synchronization
