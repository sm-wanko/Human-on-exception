# Independent AI Review Contract

## Implementer vs reviewer

The reviewer runs in a separate session / context from the implementer, such as Codex or Cursor Bugbot. Implementer self-review, including an additional self-review while resolving review findings, is not required. The default is not to perform it. If it is performed, it is only supplementary evidence and does not count as an independent review. A mere change in tone/persona does not count as an independent review.

Do not treat the implementer's "done" statement as evidence. Independently inspect the Issue, accepted decisions, applicable rules, diff, and tests.

Codex enters through the root `AGENTS.md` Review guidelines. Cursor Bugbot enters through `.cursor/BUGBOT.md`. GitHub Copilot enters through `.github/copilot-instructions.md`; Claude Code enters through `.claude/skills/independent-review/SKILL.md` and its separate-context reviewer. These are tool-specific entrypoints to this single review contract, not independent sources of review policy. Do not confuse Copilot configuration with Codex configuration.

Independent review is valid in either form below. Both require a separate session / context from the implementer. Implementer self-review and a persona change inside the implementer session do not qualify. File placement or a prompt alone is not evidence that a review happened.

### Pre-PR separate-context review

A review before a PR exists counts when a different session / context inspects a recorded base and head.

- **Base:** the intended PR base, or the Epic work branch when the change is a child Issue.
- **Head:** the commit reviewed.
- Record both refs with the review result. The review is evidence only for that head.
- A later head reuses that evidence only under [Review evidence coverage](#review-evidence-coverage). An uncovered remainder stays pending.
- This form does not depend on an external PR-review service. Do not mark it not performed only because no PR service is connected.

### External PR review service

When the review depends on a connected PR service such as Codex, Cursor Bugbot, GitHub Copilot, or Claude, verify that the service is connected and that automatic review is configured in the target environment. If the service is not connected or did not run against the target head, record that service review as not performed. If the recorded review covers an older head, record that revision and apply [Review evidence coverage](#review-evidence-coverage). A service that did not run does not by itself leave a child head pending when another valid independent review covers that head.

## Review evidence coverage

A head change does not by itself discard every earlier review. It also does not by itself extend an earlier review to the new head. Coverage is what a separate context can account for on the target base and head.

Review evidence is one record, written on the PR or with the pre-PR review. It has four parts and no separate store:

- target base and head
- reviewed scope, as paths or behaviors
- findings and whether each is resolved, still valid, false positive, or decision required
- when a later head reuses or narrows that evidence, the impact recheck: what stayed unchanged, what changed, what this review rechecked, and what is still uncovered

| Judgment | Condition | What happens |
|---|---|---|
| Reusable | The reviewed code and contract are unchanged, and a separate context records that changes in dependent behavior do not invalidate that evidence | The earlier independent review carries to that unchanged scope |
| Partial re-review | The changed places and their impact can be bounded | A separate context reviews that impact, including a path where an upstream change reaches existing downstream code |
| Full re-review | The impact cannot be bounded, or an important interaction spreads widely | A separate context reviews the latest head as a whole |

The reusable judgment is itself independent evidence. The implementation AI may name the delta. It does not declare reuse, rule out impact, or mark coverage complete. A clean merge and the absence of a conflict do not show that dependent behavior is unchanged.

Authentication, authority, and money or aggregation changes are never reusable on the ground that the edit looks local. They are at least a partial re-review. When a change fits a narrower row and this stricter one, use the stricter row.

A separate context confirms the invariant and the impact bound before unchanged evidence carries. Unchanged scope inherits that evidence. Changed scope is reviewed independently. When the impact cannot be bounded, the judgment is a full re-review. A partial re-review that finds a valid defect outside the recorded impact shows that the impact was not bounded, and the next review is full.

On one head, divide the work into four ranges: scope an earlier review inspected and that is still unchanged; scope this head changed; scope a separate context rechecked for this head; scope not yet reviewed. An uncovered range keeps the head pending. Coverage is complete when those ranges account for the head and no valid or unclassified finding remains. One finished review does not erase an unresolved finding.

A child head needs at least one valid independent review that, with any reused unchanged scope, covers that head. A second service, such as both Codex and Cursor Bugbot, is recommended. Record a service that did not run. Both services failing to run leaves the head pending.

An integration head, the PR into the branch that receives completed work, including Epic to that branch, needs a first separate-context review of that whole head. Child coverage does not supply that first review. If it did not run, the head stays pending. A usage limit is not success and is not a reason to skip to a passed review. After that whole-head review is recorded, a later head on the same integration PR uses this same coverage table. A difficult fix stays with the implementation AI. It is not `decision required`, and it is not returned to the human.

Required checks are a separate gate. Review coverage does not make a failed, skipped, pending, or not-run check successful.

## Review dimensions

- Conformance to agreed AC, Scope, and prohibitions. Distinguish current-state SoT from the agreed target contract.
- Real bugs, regressions, auth/audit issues, destructive data changes, transaction/concurrency problems, and create/update asymmetry.
- Known risk-area coverage: when the diff clearly activates a known cross-cutting risk area, verify that the applicable repository rule, accepted Policy/ADR, platform constraint, or verification method was actually considered. Inspect the evidence kinds that apply to that change; do not require a kind that does not apply, and do not leave platform constraints out of the set. Do not invent a guarantee for unknown risks, and do not treat the review checklist itself as proof of completeness. When no trusted criterion exists, the gap belongs under Risks / Unknowns / Assumptions rather than a passed review.
- UX continuity from entry through success/failure and return path. Distinguish a valid empty result from an unavailable/failed result.
- Synchronization of types, APIs, generated artifacts, fakes, tests, and the 4-point docs. Check paired/counterpart functionality when relevant.
- **SoT and omitted-file audit (MUST):** For each behavior or contract change, derive affected artifacts from the accepted Answers / Issue AC and applicable concept / active ADR / Policy; inspect implementation, corresponding system/FE tests, API/types/fakes/generated outputs, and relevant flow / ui / validation / db, transitions, and packs. Check whether each affected artifact was updated in the same change series **even if it is absent from the PR diff**. Report a missing, stale, or contradictory artifact with the target contract and affected path. Do not demand unrelated docs updates or replace an intentionally N/A responsibility. The current-state SoT order (implementation → system test → flow) establishes existing facts; the agreed Answers / Issue AC define the target, so do not use stale implementation to reject an authorized change.
- Single source of meaning, layer responsibility, and out-of-scope changes.
- Application of concept / ADR / Policy according to [domain-decisions](./domain-decisions.md). Check that aggregation units, actor boundaries, evidence promotion rules, and counterexamples remain intact. A complexity critique must identify the protected requirement and a meaning-preserving alternative.
- Whether completion claims match evidence from the latest revision. Do not let aggregate Fail=0 or excluded IDs hide unverified work.
- Differences between seed/migration paths and member UI mutations, reasoned N/A declarations, and agreed constraints.
- Human-facing review/output language follows [language-policy](./language-policy.md). Do not require duplicate translations by default. When translated copies exist, translation must not create, delete, weaken, or strengthen product meaning.

Each finding must include severity, path/line (or the expected missing file), supporting AC or rule, reproduction condition or comparison evidence, impact, and a correction direction. For SoT/docs findings, identify the changed behavior, expected artifact, and actual omission or contradiction. If an artifact cannot be inspected, mark that check unverified rather than claiming it passed. Do not inflate the review with speculation, style-only comments, or praise. State any unproven assumptions.

## Finding-resolution loop

1. When the PR stacks on another work branch and its head does not contain that branch's latest pushed head, merge that head first. Completion of the base's independent review is not a precondition. Classify every finding against the synced tree as `valid`, `false positive`, or `decision required`. Do not fix a finding the sync already removed. Fix a remaining finding in the PR that introduced it, or in the PR that owns that responsibility.
2. Fix valid findings that belong to this PR and align regression tests, docs, and verification. For false positives, cite implementation/test/agreed-contract evidence; do not close with only "by design". Rerun that PR's verification on the head after any sync.
3. For `decision required`, return the evidence and options to Questions. Do not ask humans about ordinary fixes.
4. Record the fix commit, verification evidence, and reasoning in the PR. In that same step, resolve the review thread for each valid fix and each false positive. Do not return thread resolution to the human when permission allows. If permission is missing, record that the thread stayed open. Leave a `decision required` thread unresolved. Resolving a thread does not complete independent review of the head.
5. A separate context classifies the delta since the last valid evidence as reusable, partial, or full, then reviews the uncovered scope. The implementation AI requests that classification and review. It does not perform them as self-review and does not declare reuse. For a child head, one valid independent review is enough; requesting both Codex and Cursor Bugbot is recommended, and a service that did not run is recorded. For an integration head, the first review is of that whole head, and child coverage does not supply it. After that review is recorded, the same classification applies: the separate context confirms the invariant and the impact, unchanged scope carries, changed scope is re-reviewed, and an impact that cannot be bounded returns to a full re-review. Zero findings or green checks are not substitutes for an uncovered range. An unresolved valid or unclassified finding keeps the head pending. Do not return the implementation to the human because the fix is difficult.

Completion follows [ai-workflow.md](./ai-workflow.md) §5. While independent review of the target head is pending, status is review pending; do not silently replace it with a mandatory human-review gate.
