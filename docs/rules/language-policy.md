# Language Policy

Human-on-Exception uses English for agent-facing execution material and English + Japanese for human-facing decision material.

## Audience

| Material | Language |
|---|---|
| Agent-facing rules and repository instructions | English |
| Human-facing intent, concept, Questions, ADR, Policy, and reusable prompts | English + Japanese |
| Product-specific flow / ui / validation / db docs | Project language; bilingual is allowed |

Language is presentation only. It does not change authority or Source of Truth.

## Semantic parity

Bilingual sections MUST preserve the same intent, scope, decisions, constraints, risks, non-goals, actors, units, and evidence meaning.

Neither language may add or remove a decision, weaken or strengthen a requirement, turn a recommendation into an accepted answer, or silently omit an exception or prohibition.

## If translations disagree

Treat the mismatch as a documentation defect. Do not silently choose one language.

Resolve the meaning from the human answer, active ADR / Policy, current Issue AC, and current-state SoT as applicable. Then update both languages together. If the underlying meaning is still ambiguous, return only that ambiguity to the human.

## Translation-only changes

A translation-only change MUST NOT alter Intent / Scope / Answer / Risk acceptance, semantic boundaries, API / DB / UI behavior, acceptance criteria, tests, or SoT order.

Humans may answer Questions in their primary language. AI is responsible for carrying that meaning into the bilingual material without changing it.

**English improves portability. Human language must not become a barrier to deciding meaning.**
