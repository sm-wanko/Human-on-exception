# Operating Evidence

Prompt evals and CI verify local behavior.

This document describes the stronger evidence needed to support the Human-on-Exception hypothesis over time.

## Hypothesis

> Software development can remain reliable while human participation is compressed to intent, boundary decisions, and exceptional ambiguity.

## Evidence categories

### 1. Human attention

Record, per meaningful change/PR when practical:

- initial intent event
- number of human Answer events
- number of routine engineering interventions
- number of human-provided file/Flow coordinates
- number of human review/adjudication interventions

### 2. Autonomous closure

Record whether AI completed:

- Questions generation
- Issue decomposition
- implementation
- tests/docs
- reviewer adjudication
- merge preparation

without routine human coordination.

### 3. Review quality

Record:

- valid AI-review findings
- false positives
- ambiguous findings
- AI-only closure rate
- findings that escaped to production/later regression

### 4. Continuity

Observe whether later agents can recover context without:

- the original implementing agent
- manual maintainer explanation
- repository-wide context loading

### 5. Correctness

Track escaped regressions, broken migrations/contracts, and incidents independently from human-attention reduction.

## Interpretation

Strong evidence is not:

> "AI completed one impressive PR."

Stronger evidence is:

> "Over many changes, repository complexity increased while routine human coordination did not increase proportionally, and correctness remained acceptable."

## Suggested summary metrics

Projects may publish or privately track:

- human interventions / PR
- genuine Questions / PR
- repeated/unnecessary Questions / PR
- AI-only review closure %
- human-provided coordinate count
- escaped regression count/rate
- median context bundle size or number of files read, when observable

Do not optimize metrics mechanically. Use them to detect when humans are creeping back into routine loops.
