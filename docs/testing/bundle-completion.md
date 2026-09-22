# Bundle Completion

A feature bundle is not Done merely because tests pass or the Flow-ID gap is zero.

Before marking a Pack/Flow bundle complete, verify all applicable dimensions.

## 1. Current docs

- Flow is current
- UI / Validation / DB are current or explicitly N/A
- no historical debate is stored as current behavior
- route/navigation docs are updated if the project has them

## 2. Pack / routing

- Pack scope/non-scope is current
- Pack points to current implementation/test paths
- core-feature index maps the feature to the correct Pack and Flow
- Pack does not duplicate feature specification prose

## 3. Implementation

- Issue acceptance criteria are satisfied
- protected boundaries were not changed accidentally
- architecture/dependency rules are respected
- migrations/compatibility obligations are complete

## 4. Verification

- every planned SYS/FE ID has executable coverage or explicit reasoned N/A
- executable SYS/FE IDs are represented in the Flow matrix
- normal and negative cases cover relevant request/response/state/side effects
- required project lint/test commands pass

## 5. Review

- valid reviewer findings are resolved
- false positives are rejected with evidence rather than implemented blindly
- no genuine ambiguity remains hidden in code

## 6. Decision history

- blocking Questions are answered
- Confirmed Decisions reflect final boundaries
- implementation handoff / Issue decomposition is no longer stale
- durable cross-feature rationale is promoted to ADR when needed

## 7. Survey

Run the repository survey and project-specific structural checks.

**Gap 0 is evidence, not the whole Done definition.**
