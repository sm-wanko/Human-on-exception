# Independent Review and Adjudication

## Independence

Implementation and review are separate roles/lineages.

A reviewer is a **detector**, not a Source of Truth.

Review must prioritize:

- concrete bugs/regressions
- security/auth/privacy boundary violations
- data loss/corruption
- migration/rollout hazards
- API/current-contract deviations
- broken transaction/failure semantics
- cache/job/event consistency mistakes
- cross-layer dependency violations
- missing verification when omission creates real behavior risk

Style preference and alternative-design preference are not findings by themselves.

## Review is not diff-only reading

Start from the diff, but inspect repository context whenever correctness depends on it.

For a changed behavior, check applicable:

1. Issue acceptance criteria and protected scope
2. confirmed Questions/Answers
3. current Flow/UI/Validation/DB
4. executable tests
5. project architecture/rules
6. callers/consumers of changed API/read model
7. persistence/migration/data ownership
8. auth/security/audit behavior
9. cache/job/event/external side effects
10. sibling/parity path when the change claims shared behavior

Do not search every category mechanically. Widen review according to concrete risk.

## Reviewer false-positive suppression

Do not report:

- a different design that is merely preferable
- style-only/naming-only suggestions with no contract/risk effect
- requirements inferred from historical Questions that current truth superseded
- "missing" behavior explicitly N/A/non-scope
- a docs/code difference without first checking Source-of-Truth order and staleness
- generalized framework advice that conflicts with project-specific rules

## Finding quality bar

Each finding should contain:

1. concrete problem
2. affected user/path/data/contract
3. why current repository evidence makes it a defect
4. reproduction/verification route when possible
5. concise correction direction

A finding should be specific enough that the implementation agent can independently verify or falsify it.

## Adjudication

Implementation-side AI must re-investigate every finding.

Classify:

- **valid** — repository evidence confirms a defect/risk
- **false positive** — current contract/evidence shows behavior is correct
- **genuinely ambiguous** — multiple materially valid intended outcomes remain

Actions:

- valid → reproduce/confirm → fix → add/update tests/docs → run checks → reply → resolve
- false positive → no speculative code change → reply with concrete evidence → resolve/reject
- ambiguous → escalate only the unresolved decision with options, impact, and recommendation

Never escalate merely because reviewer and implementation agent disagree.

## Re-review

After fixes:

- inspect the resulting diff again
- rerun affected checks
- verify no new contract/docs/test drift was introduced
- request/run independent review again when the change materially altered the original fix surface
