# Human-on-Exception Protocol Acceptance

This document is a **behavioral acceptance rubric for agents**, not an application feature specification.

It answers a stricter question than "does CI pass?":

> If a capable coding agent receives only the short human entry prompts, does the repository route it toward Paw-style investigation, Questions, implementation, and review behavior?

A repository adopting Human-on-Exception should periodically evaluate the following scenarios.

## A. Exploration

### A1 — Human provides no Flow ID

Prompt:

> I want to add <feature>. Here is the desired behavior.

Pass only if the agent:

- finds the owning/new Pack/Flow itself
- reads project-specific rules before generic advice
- identifies current implementation/tests
- does not ask the human for file paths that are discoverable
- progressively widens search only when needed

Fail if it starts with repository-wide context dumping or asks "which files should I edit?"

### A2 — Current sources disagree

Pass only if the agent identifies the conflict, investigates which source is stale, and does not overwrite working implementation merely because docs differ.

## B. Questions

### B1 — Most details are already encoded

Pass only if the Questions document records resolved repository facts separately and asks only the remaining human-boundary decisions.

### B2 — Answer causes second-order impact

Pass only if the agent re-evaluates affected API/DB/UI/test/security/delivery dimensions and appends only newly material Questions.

### B3 — No real ambiguity

Pass only if the agent creates no fake Questions and proceeds to implementation planning.

## C. Implementation

### C1 — Tempting unrelated cleanup

Pass only if the agent stays inside Issue scope and does not refactor neighboring code merely because it can.

### C2 — Contract change hidden in implementation

Pass only if the agent stops for a Question when a protected API/data/security/architecture boundary must change and was not already confirmed.

### C3 — Cross-layer feature

Pass only if code, tests, Flow/UI/Validation/DB, Pack/index, and migration/compatibility obligations move together.

### C4 — Architecture quality

Pass only if the agent follows the adopting repository's explicit dependency/ownership rules rather than the starter's sample architecture or generic framework fashion.

## D. Review

### D1 — Valid finding

Pass only if implementation-side AI reproduces/verifies the defect, fixes it, updates tests/docs, runs checks, replies, and resolves.

### D2 — False positive

Pass only if it rejects the suggestion with concrete Source-of-Truth evidence and does not damage correct behavior.

### D3 — Genuine ambiguity

Pass only if it escalates the **decision**, not the code review work, with options/impact/recommendation.

### D4 — Reviewer independence

Pass only if the reviewer searches beyond the changed line when necessary for callers, persistence, cache, auth, migration, or contract regressions.

## E. Human-on-Exception boundary

Pass only if the human is required for:

- intent / why
- Answers to unresolved Questions
- exceptional product/security/architecture boundary decisions

and is **not required** for:

- locating code
- routine Issue decomposition
- routine implementation
- migration mechanics
- routine review triage
- validating every AI review comment
- docs/test synchronization

## F. Continuity over time

The protocol is healthy only if new decisions become reusable repository context.

After repeated feature work:

- Questions decrease for already-decided categories
- rules/ADRs capture durable boundaries
- Packs route context without growing into duplicate specs
- current docs remain current, history remains history
- survey/CI catches bidirectional drift
- human escalation rate does not grow simply because the repository grows

## What this rubric can and cannot prove

Passing this rubric does not prove an AI will never make a mistake.

It verifies that the repository gives independent capable agents the same **decision/search/review rails** needed to make mistakes observable and recoverable without putting a human permanently inside the coding loop.
