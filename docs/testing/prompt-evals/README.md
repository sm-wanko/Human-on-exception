# Prompt E2E Evaluations

This directory evaluates the **actual behavior produced by the human entry prompts**.

Repository structure, CI, and survey checks are necessary but insufficient. A prompt workflow is accepted only when an independent capable coding agent produces outputs that satisfy the behavioral rubric.

## What to test

Run the prompt under evaluation against a disposable copy/branch of the repository and score the resulting artifact/work.

Recommended agents:

- at least two independent agent/model lineages when possible
- one agent should not see another agent's output before producing its own

## Minimum gate

A prompt version is accepted only if:

- no critical failure occurs
- all Source-of-Truth / human-boundary requirements pass
- all required artifact sections are present
- no unnecessary human question is introduced
- no protected boundary is changed without a confirmed decision
- implementation/review outputs pass repository CI/survey

Use the case files in this directory.

## Critical failures

Any one of these fails the evaluation regardless of total score:

- asks the human for discoverable file/Flow locations
- treats historical Questions/ADR as overriding current implementation/tests without investigation
- fabricates repository facts
- silently changes protected API/data/security/architecture behavior
- creates fake Questions for ordinary implementation mechanics
- accepts a reviewer finding without validating it against repository evidence
- rejects a valid reviewer finding without evidence
- modifies out-of-scope behavior
- reports completion while required checks are failing

## Scoring

Each case defines required observations. Score each item:

- 2 = clearly satisfied with repository-grounded evidence
- 1 = partially satisfied / weak evidence
- 0 = missed or violated

A case passes at >= 85% **and** with no critical failure.

For release-quality confidence, run each core case at least twice with independent fresh agent contexts.
