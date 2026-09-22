# Development Loop

This file describes the normal operating loop.

The canonical division of responsibility lives in [responsibility-boundary.md](./responsibility-boundary.md).

## Normal path

1. Human provides intent / why / desired outcome.
2. Agent resolves repository context itself.
3. Agent creates Questions only for unresolved human-owned decisions.
4. Human answers those decisions.
5. Agent repeats impact analysis until the boundary is closed.
6. Agent creates Issue(s) / Epic structure.
7. Agent implements code, migrations, tests, and current-contract docs.
8. Agent opens linked PR(s).
9. Independent AI reviewer inspects the work.
10. Implementation AI adjudicates all findings.
11. Human is re-entered only for a genuinely unresolved decision.
12. Agent repairs, re-verifies, merges, and updates repository routing/history.

## Human touchpoints

Normal feature development should require human participation at only these points:

### 1. Intent

The human states what should change and why.

### 2. Answers

The human resolves Questions that cannot be answered from repository evidence and belong to product/authority judgment.

### 3. Optional observation

The human may inspect outcomes, but routine diff review is not a required protocol step.

## Stop conditions

### Exploration

Do not ask the human for discoverable coordinates. Search until ownership/current truth is known or a real decision remains.

### Questions

Stop for the human only when a human-owned boundary remains unresolved.

### Issue creation

Do not begin implementation while a blocking decision is still PENDING.

### Implementation

Do not expand scope merely because nearby cleanup is attractive.

Do not stop on routine technical difficulty. Investigate/fix within the confirmed boundary.

### Review

Do not blindly implement reviewer claims and do not ask the human to arbitrate evidence that the repository can resolve.

### Merge

Do not merge while required checks fail, a valid finding remains unresolved, or a genuine ambiguity is still open.

## Continuity requirement

Completion includes leaving enough reusable repository context that the next agent does not need the previous agent or a human to reconstruct the work.

## Anti-pattern

This is not Human-on-Exception:

```text
Human request
→ AI codes
→ Human finds files
→ Human reviews diff
→ Human interprets reviewer comments
→ Human tells AI what to fix
→ Human verifies docs/tests
→ Human merges
```

That is AI-assisted development with a human coordination bottleneck.

The target is:

```text
Human intent
→ AI engineering loop
→ Human only on exceptional decision
→ AI engineering loop resumes
```
