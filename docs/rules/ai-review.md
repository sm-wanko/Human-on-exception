# Independent AI Review Contract

## Implementer vs reviewer

The reviewer runs in a separate session / context from the implementer, such as Codex or Cursor Bugbot. Implementer self-review is not required. If it is performed, it is only supplementary evidence and does not count as an independent review. A mere change in tone/persona does not count as an independent review.

Do not treat the implementer's "done" statement as evidence. Independently inspect the Issue, accepted decisions, applicable rules, diff, and tests.

Codex enters through the root `AGENTS.md` Review guidelines. Cursor Bugbot enters through `.cursor/BUGBOT.md`. GitHub Copilot enters through `.github/copilot-instructions.md`; Claude Code enters through `.claude/skills/independent-review/SKILL.md` and its separate-context reviewer. These are tool-specific entrypoints to this single review contract, not independent sources of review policy. Do not confuse Copilot configuration with Codex configuration.

Verify service connection and automatic-review configuration in the target environment. If the service is not connected or did not run, record the review as not performed. File placement alone is not evidence that a review happened.

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
5. A separate-context AI rechecks the latest diff. Zero findings or green checks are not substitutes for an unperformed review. If review evidence covers an older head, record that revision and review later changes again.

Completion follows [ai-workflow.md](./ai-workflow.md) §5. While an external review is pending, status is review pending; do not silently replace it with a mandatory human-review gate.
