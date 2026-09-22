# Documentation Contract

## Purpose

Current behavior must be understandable without reverse-engineering implementation. Documentation is also the routing surface agents use to recover feature context.

## The four-document set

Every user-visible or externally meaningful feature is anchored by one Flow document and, where applicable, matching UI, Validation, and DB documents.

| Document | Owns |
|---|---|
| Flow | scope, entry point, normal/alternate flow, service/API order, test matrix |
| UI | visible states, user operations, navigation |
| Validation | input, authentication/authorization, errors |
| DB | persisted state, transaction boundary, mutation result |

Do not duplicate the same prose/table across all four documents. Each document owns one concern.

## Same-change rule

A behavior change must update implementation, tests, and every affected member of the four-document set in the same PR/change series.

Do not leave Flow current while Validation/DB silently describe the old contract.

## N/A is explicit

If a quadrant genuinely has no responsibility, say so explicitly.

Examples:

- API-only feature with no UI → UI document says N/A and why.
- Read-only computation with no persistence → DB document says N/A and names the actual side effects, if any.

N/A means "this concern does not apply", not "not investigated" or "not implemented yet".

## Current contract vs history

Flow/UI/Validation/DB contain only current behavior.

Do not store migration history, obsolete behavior, old IDs, or debate in the current contract. Put decision history in Questions/Answers and durable rationale in ADRs.

## Flow IDs and tests

Every feature gets a stable `FLOW_ID`.

System/vertical test IDs use:

- `<FLOW_ID>-SYS-001..099` happy/normal behavior
- `<FLOW_ID>-SYS-101..199` error/negative behavior

Frontend/interaction contract IDs may use `<FLOW_ID>-FE-NNN`.

The Flow test matrix is the planning source for these IDs. Test names must include the exact ID so coverage can be audited.

## Completion

Before a feature is Done:

- four-document set is current or explicitly N/A
- test matrix matches executable tests
- implementation matches current docs
- historical Questions are marked implemented/archived
- relevant Pack/index points to the feature
