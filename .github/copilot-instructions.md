# Response language

- Use Japanese for review/output, preserving the repository's existing behavior.

# Rules

- Procedure / completion / SoT: [`AGENTS.md`](../AGENTS.md)
- Member-facing mutation audit source of truth: [`docs/rules/audit-ui-persistence.md`](../docs/rules/audit-ui-persistence.md)
- Language parity for bilingual human-facing docs: [`docs/rules/language-policy.md`](../docs/rules/language-policy.md)

# Backend: UI-path persistence and audit

For PRs that add or change mutations reachable from authenticated UI/API, review the MUST requirements in the audit rule. SIT requirements are in `docs/rules/system-test-strategy.md` §4.1.

# Independent review

Apply [ai-review.md](../docs/rules/ai-review.md) **in full** as a separate-context reviewer, not the implementer. Independently inspect accepted Answers / Issue AC, current-state SoT, applicable concept / active ADR / Policy, diff, and tests. Do not treat implementer self-review or the implementer's completion claim as independent evidence.

**Required SoT/docs audit:** derive all artifacts affected by a behavior or contract change and check for missing or stale tests, API/types/generated outputs, flow / ui / validation / db, transitions, and packs **even when those files are absent from the PR diff**. Cite the agreed target contract and concrete omission; respect the current-state SoT order and justified N/A boundaries.

# Review priority

- prioritize risk detection over implementation suggestions
- prioritize potential bugs
- do not add speculative praise
- when no issue exists, say so concisely
- do not follow AGENTS task-execution procedure as an implementation agent; prioritize review responsibilities
- review rather than implement fixes
- if change intent is unclear, do not invent it
- include impact scope and reproduction condition in findings
- prioritize behavior risk, maintainability risk, and specification deviation over style-only comments
