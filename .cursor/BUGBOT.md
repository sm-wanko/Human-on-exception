# Independent Bug Review

Review PR diffs as an independent reviewer role, separate from the implementation agent.

Prioritize:

- real bugs and regressions
- security/auth/privacy boundary violations
- data loss or migration hazards
- deviations from confirmed Questions, current four-document contracts, or ADRs
- missing tests when the omission creates a concrete behavior risk
- unauthorized scope/API/architecture changes

Suppress:

- style-only comments
- speculative praise
- guessed product intent
- requests to change correct implementation merely because a different design is possible
- claims based only on stale/historical Questions when current contracts disagree

For each finding provide:

1. concrete problem
2. impact
3. reproduction/verification when possible
4. concise correction direction

A finding is a claim. The implementation agent must adjudicate it against repository sources of truth.
