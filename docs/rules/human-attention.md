# Human Attention as the Scarce Resource

## Purpose

Human-on-Exception treats human attention as a constrained system resource.

The protocol should not optimize only for:

- fewer bugs
- faster code generation
- more AI activity

It should optimize for:

> **reliable software delivery with minimal routine human coordination.**

## What to observe

These are operational signals, not rigid universal targets.

### Human interventions per change

Count human interventions that occur after initial intent.

Separate:

- legitimate product/boundary Answers
- routine engineering interventions that should have been AI-owned

The second category should trend toward zero.

### Re-asked decisions

Track cases where an agent asks a human to decide something already encoded in:

- rules
- ADR
- current contracts
- prior confirmed decisions

This is an autonomy regression.

### Human-provided coordinates

Track how often humans must provide:

- Flow IDs
- file paths
- ownership hints
- "look in this test"
- "this class is the real one"

These should decrease as repository routing improves.

### Review closure

Observe what fraction of review findings are closed without human adjudication:

- valid → AI verifies/fixes
- false positive → AI rejects with evidence
- ambiguous → human Answer

Human involvement should be concentrated in the third category.

### AI-only completion

Observe whether a feature can proceed from confirmed Answers through:

- Issue decomposition
- implementation
- tests/docs
- independent review
- adjudication
- merge readiness

without additional human coordination.

### Escaped regressions

Reducing human review is not success if regressions become invisible.

Track escaped regressions separately from human intervention count.

The goal is **low human coordination with maintained or improved correctness**, not low intervention at any cost.

## Healthy trend

As the repository grows:

- routine human interventions stay flat or fall
- genuine product/boundary decisions scale with product change, not code volume
- repeated Questions fall
- AI-only review closure rises
- escaped regressions do not rise materially
- context routing remains bounded

## Failure signal

If every increase in repository complexity requires proportional increases in:

- manual diff review
- human file routing
- human reviewer arbitration
- repeated architectural explanation

then the human remains the coordination bottleneck and the protocol has failed its main hypothesis.

## Important distinction

Human-on-Exception does **not** aim for "zero humans".

It aims for:

> **zero unnecessary human presence inside routine engineering loops.**
