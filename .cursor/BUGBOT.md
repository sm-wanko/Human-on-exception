# Bugbot (Human-on-Exception)

For PR diff review. This is separate from IDE Agent rules under `.cursor/rules/*.mdc`.

Apply the [independent AI review contract](../docs/rules/ai-review.md) and evaluate AC / diff / tests from a context separate from the implementer.

**Write review comments in Japanese**, preserving the repository's existing review-language behavior.

Prioritize **bugs, security, specification deviation, and regression risk** over implementation suggestions. Do not add style-only comments, speculative praise, or speculation about change intent. If there is no issue, keep the review concise.

Shared sources of truth — open only when needed:

- [AGENTS.md](../AGENTS.md)
- [.github/copilot-instructions.md](../.github/copilot-instructions.md)

---

## Valid findings

- real bugs, regressions, destructive data changes, authorization leaks, unsafe auth/CORS relaxation
- out-of-scope API contract or business-logic changes, or layer violations
- missing audit behavior on member-facing mutations
- missing tests when the absence creates concrete behavior risk

## Findings to suppress as false positives

- migration / seed / fixture audit values differing from member UI-path audit values
- no audit migration for a table whose schema intentionally has no audit columns
- treating a Flow boundary explicitly marked N/A as "unfinished"
- demanding implementation changes based only on docs when current-state SoT is implementation → system test → flow
- lint/format-only differences or pure comment/docs wording cleanup unless they create risk

---

## Backend: member-facing mutation audit

When a PR adds or changes create/update/delete-equivalent behavior under `apps/backend/app/**` reachable from authenticated UI/API, apply the MUST rules in [audit-ui-persistence.md](../docs/rules/audit-ui-persistence.md).

---

## Change-scope guardrails

Unless explicitly requested or explained in the PR, treat these as high-priority findings:

- API parameter / response-shape changes
- removal or weakening of auth, CORS, or security settings
- business logic added to route/bootstrap wiring
- layer responsibility crossing such as Controller→DB or Repository→HTTP

---

## Finding format

Each finding should include:

1. what is wrong in 1–2 sentences
2. impact scope — who/data/path
3. reproduction or confirmation steps when known
4. preferred correction direction without rewriting the whole implementation
