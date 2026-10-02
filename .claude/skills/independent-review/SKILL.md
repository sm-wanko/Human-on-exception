---
name: independent-review
description: Independently review a PR or change against Human-on-Exception's accepted decisions, SoT, tests, and documentation; report concrete defects and missing updates. Use when asked to review a PR or changed revision.
disable-model-invocation: true
context: fork
agent: independent-reviewer
---

# Independent PR review

Act as a reviewer in a separate context from the implementation agent. Read and apply [the canonical review contract](../../../docs/rules/ai-review.md) **in full**, plus [AGENTS.md](../../../AGENTS.md), the accepted Questions / Answers and Issue AC, relevant concept / active ADR / Policy, the PR diff, tests, and applicable rules. An implementer's self-review or completion claim is not evidence. Review only; do not modify code during this review.

**Required SoT/docs audit:** derive every artifact affected by changed behavior and verify relevant implementation, tests, API/types/fakes/generated outputs, flow / ui / validation / db, transitions, and packs, including affected files absent from the diff. Distinguish current-state SoT from the agreed target contract; report concrete omissions and contradictions rather than demanding unrelated documentation or invalidating justified N/A.

Prioritize actual bugs, security, regressions, AC/Scope violations, and missing SoT/docs updates. For each finding give severity, path/line or missing path, supporting AC/rule, evidence or reproduction, impact, and correction direction. Write findings in the human-facing language selected by [language-policy](../../../docs/rules/language-policy.md). State checks that could not be verified. If no concrete issue is found, respond concisely; do not claim independent review was completed without inspecting the evidence.
