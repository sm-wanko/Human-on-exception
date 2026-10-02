# Independent AI Review Contract

## Implementer vs reviewer

The reviewer runs in a separate session / context from the implementer, such as Codex or Cursor Bugbot. Implementer self-review is not required. If it is performed, it is only supplementary evidence and does not count as an independent review. A mere change in tone/persona does not count as an independent review.

Do not treat the implementer's "done" statement as evidence. Independently inspect the Issue, accepted decisions, applicable rules, diff, and tests.

Codex enters through the root `AGENTS.md` Review guidelines. Cursor Bugbot enters through `.cursor/BUGBOT.md`. GitHub Copilot enters through `.github/copilot-instructions.md`; Claude Code enters through `.claude/skills/independent-review/SKILL.md` and its separate-context reviewer. These are tool-specific entrypoints to this single review contract, not independent sources of review policy. Do not confuse Copilot configuration with Codex configuration.

Independent review is valid in either form below. Both require a separate session / context from the implementer. Implementer self-review and a persona change inside the implementer session do not qualify. File placement or a prompt alone is not evidence that a review happened.

### Pre-PR separate-context review

A review before a PR exists counts when a different session / context inspects a recorded base and head.

- **Base:** the intended PR base, or the Epic work branch when the change is a child Issue.
- **Head:** the commit reviewed.
- Record both refs with the review result. The review is evidence only for that head.
- If later commits change the head, review the new head again before treating independent review as complete. Evidence for an older head does not cover the later commits.
- This form does not depend on an external PR-review service. Do not mark it not performed only because no PR service is connected.

### External PR review service

When the review depends on a connected PR service such as Codex, Cursor Bugbot, GitHub Copilot, or Claude, verify that the service is connected and that automatic review is configured in the target environment. If the service is not connected or did not run against the target head, record that service review as not performed. If the recorded review covers an older head, record that revision and review the later changes again.

## Review dimensions

- Conformance to agreed AC, Scope, and prohibitions. Distinguish current-state SoT from the agreed target contract.
- Real bugs, regressions, auth/audit issues, destructive data changes, transaction/concurrency problems, and create/update asymmetry.
- UX continuity from entry through success/failure and return path. Distinguish a valid empty result from an unavailable/failed result.
- Synchronization of types, APIs, generated artifacts, fakes, tests, and the 4-point docs. Check paired/counterpart functionality when relevant.
- **SoT and omitted-file audit (MUST):** For each behavior or contract change, derive affected artifacts from the accepted Answers / Issue AC and applicable concept / active ADR / Policy; inspect implementation, corresponding system/FE tests, API/types/fakes/generated outputs, and relevant flow / ui / validation / db, transitions, and packs. Check whether each affected artifact was updated in the same change series **even if it is absent from the PR diff**. Report a missing, stale, or contradictory artifact with the target contract and affected path. Do not demand unrelated docs updates or replace an intentionally N/A responsibility. The current-state SoT order (implementation → system test → flow) establishes existing facts; the agreed Answers / Issue AC define the target, so do not use stale implementation to reject an authorized change.
- Single source of meaning, layer responsibility, and out-of-scope changes.
- Application of concept / ADR / Policy according to [domain-decisions](./domain-decisions.md). Check that aggregation units, actor boundaries, evidence promotion rules, and counterexamples remain intact. A complexity critique must identify the protected requirement and a meaning-preserving alternative.
- Whether completion claims match evidence from the latest revision. Do not let aggregate Fail=0 or excluded IDs hide unverified work.
- Differences between seed/migration paths and member UI mutations, reasoned N/A declarations, and agreed constraints.
- Language parity for bilingual decision material according to [language-policy](./language-policy.md). Translation must not create, delete, weaken, or strengthen product meaning.

Each finding must include severity, path/line (or the expected missing file), supporting AC or rule, reproduction condition or comparison evidence, impact, and a correction direction. For SoT/docs findings, identify the changed behavior, expected artifact, and actual omission or contradiction. If an artifact cannot be inspected, mark that check unverified rather than claiming it passed. Do not inflate the review with speculation, style-only comments, or praise. State any unproven assumptions.

## Finding-resolution loop

1. The implementation AI lists every finding and classifies it as `valid`, `false positive`, or `decision required`.
2. Fix valid findings and align regression tests, docs, and verification. For false positives, cite implementation/test/agreed-contract evidence; do not close with only "by design".
3. For `decision required`, return the evidence and options to Questions. Do not ask humans about ordinary fixes.
4. Record the fix commit, verification evidence, and reasoning in the PR, then resolve the corresponding thread when permissions allow.
5. A separate-context AI rechecks the latest target head, whether the previous review was pre-PR or on the PR. Zero findings or green checks are not substitutes for an unperformed review. If review evidence covers an older head, record that revision and review the new target head again, including interaction with unchanged parts of that head.

Completion follows [ai-workflow.md](./ai-workflow.md) §5. While independent review of the target head is pending, status is review pending; do not silently replace it with a mandatory human-review gate.
