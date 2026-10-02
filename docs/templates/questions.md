# <Feature> — Questions

> Human-facing decision template. Render the generated document in the language selected by [language-policy](../rules/language-policy.md). Do not duplicate the same content in another language unless explicitly requested or required by the project. Stable IDs such as Q1 and AC-01 remain unchanged.

**Status**: Draft / Awaiting answers / Partially decided / Ready / Superseded  
**Pack / Flow ID**: <existing or proposed>  
**Investigation revision**: <SHA>  
**Related**: <concept / Issue / active ADR / Policy / rules / 4-point docs>

## Goal / Scope

- Problem / success condition:
- Scope:
- Non-goals / required follow-up:
- Contracts to preserve:

## Current facts

| Fact | Evidence path, symbol, revision | Affected route |
|---|---|---|
| <investigated fact> | <real reference> | <UI / API / DB / counterpart> |

## Risks / Unknowns / Assumptions

Investigate concept, units, actors, and evidence meaning through [domain-decisions](../rules/domain-decisions.md). Record applicable criteria, accepted examples, and similar-looking rejected counterexamples. Do not force an unknown concept into a nearby existing concept.

| Kind | Detail + impact | Evidence | Owner |
|---|---|---|---|
| <Risk / Unknown / Assumption> | <specific> | <reference> | <AI investigation / Q-ID / existing acceptance> |

## Investigation dimensions

For every dimension in [ai-workflow](../rules/ai-workflow.md) §2, record a related Q-ID, AI technical decision, or reasoned N/A. Do not hide an uninvestigated dimension behind N/A.

## Questions

### Q1 — <Human decision>

- Background / concrete example:
- Why human authority is required:
- A: <effect on UX / data / compatibility / risk>
- B: <effect on the same dimensions>
- Recommendation + reason:
- What remains blocked without an answer:

## Answers / Decision history

| Q-ID | Answer | Reason | Source + date/reference | Status / superseded by |
|---|---|---|---|---|
| Q1 | unanswered | — | — | Open |

Do not copy the recommendation into Answer. Do not silently overwrite a previous answer.

## AI technical decisions

| Item | Decision | Rule/code evidence | Why no human decision is required |
|---|---|---|---|
| <implementation detail> | <choice> | <rule/code> | <within delegated authority> |

## Decision → Acceptance Criteria

| Q-ID / decision | AC-ID | Preconditions/action/observable result | SYS / FE-ID or method | docs |
|---|---|---|---|---|
| <Q-ID> | AC-01 | <positive/reverse/boundary> | <tracked during implementation> | <update target> |

## Unresolved / Deferred

| Item | blocker / defer | Reason + stopped scope | Resume condition / follow-up Issue |
|---|---|---|---|

## Issue split / completion make

AI specifies Pack / Flow / allowed paths / prohibitions / dependency order / completion commands. Ready means zero implementation blockers. Implementation progress belongs in Issue / PR.
