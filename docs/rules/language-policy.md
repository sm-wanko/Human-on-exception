# Language Policy

Human-on-Exception uses English for agent-facing execution material. Human-facing material uses one selected human language by default; parallel translations are generated only when they are explicitly requested or required by the project.

## Language selection

Choose the language for human-facing intent, concept, Questions, ADR, Policy, reusable prompts, reviews, and responses in this order:

1. An explicit language instruction for the current material or output.
2. Otherwise, the language used by the human in the controlling request, requirement, or Answers.
3. If that signal is absent or genuinely ambiguous, preserve the existing project/document language.

Do not ask the human to choose a language when the rule above determines it.

## Audience

| Material | Language |
|---|---|
| Agent-facing rules and repository instructions | English |
| Human-facing intent, concept, Questions, ADR, Policy, reusable prompts, reviews, and responses | Selected human language |
| Product-specific flow / ui / validation / db docs | Project/document language unless explicitly requested otherwise |

Language is presentation only. It does not change authority or Source of Truth.

## Avoid duplicate translations by default

Do not store the same decision-relevant content in multiple languages merely for portability.

If another language is needed, translate it on demand from the authoritative material. A translated copy may be persisted when a human explicitly requests it or when the project has a documented multilingual requirement.

Existing bilingual material does not need to be rewritten solely to satisfy this policy. When it is touched for another reason, it may be normalized to one selected language if doing so preserves references and decision history.

## Semantic parity when translations exist

When multiple language versions exist, they MUST preserve the same intent, scope, decisions, constraints, risks, non-goals, actors, units, and evidence meaning.

No translation may add or remove a decision, weaken or strengthen a requirement, turn a recommendation into an accepted answer, or silently omit an exception or prohibition.

## If translations disagree

Treat the mismatch as a documentation defect. Do not silently choose a translation based on wording alone.

Resolve the meaning from the human answer, active ADR / Policy, current Issue AC, and current-state SoT as applicable. Then update the required language material. If the underlying meaning is still ambiguous, return only that ambiguity to the human.

## Translation-only changes

A translation-only change MUST NOT alter Intent / Scope / Answer / Risk acceptance, semantic boundaries, API / DB / UI behavior, acceptance criteria, tests, or SoT order.

Humans may answer Questions in their primary language. AI is responsible for carrying that meaning into implementation contracts and any requested translation without changing it.

**Portability comes from being able to translate on demand. Human language must not become a barrier to deciding meaning, and duplicate translations should not consume context by default.**
