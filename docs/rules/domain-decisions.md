# Product Meaning and Decision Inheritance

This rule defines how AI turns human-decided purpose and boundaries into concrete specification, implementation, and verification. Use it with [ai-workflow.md](./ai-workflow.md).

Do not infer this repository's product purpose from workflow names, framework conventions, implementation size, or generic software categories.

## Investigation entrypoint

From the relevant Pack / Flow, follow only the related concept, active ADR, and Policy. Understand purpose, terminology, units, actor boundaries, and decision reasons before generating Questions. Do not load every document by default.

| Material | What it answers | When to update |
|---|---|---|
| [concept](../concept/README.md) | Whose problem is solved, purpose, core concepts, success conditions, non-goals | Agreed purpose/core concept changes |
| [ADR](../testing/adr/README.md) | What was selected/rejected and why | Durable design decisions about meaning, authority, compatibility |
| [Policy](../testing/policy/README.md) | How an already accepted decision is repeatedly applied | A repeatable decision process appears |
| Questions / Issue | What is unresolved; which answers/scope/AC are accepted for this change | Decision-making and scope definition |
| code / 4-point docs / test | How the product currently behaves and what is verified | Implementation changes |

For a new product, AI drafts concept material and asks only about unresolved purpose/boundary decisions. Do not require humans to author documentation. Create ADR / Policy only when there is an actual decision or repeatable rule; do not create empty files to satisfy a count.

Follow [language-policy.md](./language-policy.md) for bilingual human-facing decision material.

## Checks that protect meaning

For the affected feature, investigate the dimensions below. Do not re-ask what existing evidence already determines. Return to human decision only when multiple interpretations would change the promise made to users.

| Dimension | What to check |
|---|---|
| Concept vs expression | Distinguish display labels, input wording, internal IDs, and classification roles. Similar wording is not proof of identical concepts |
| Trust boundary | Input assumptions, contract-external input, where assumptions are enforced, and what remains unguaranteed |
| Examples / counterexamples | Accepted examples, similar-looking but rejected examples, omitted/unknown/unsatisfied outcomes |
| Display vs evaluation | Meaning of internal evaluation versus user-visible claims. Do not present reference/candidate information as confirmed fact |
| Actors / proxying | Distinguish authentication actor, operating actor, owner/manager, experience/record subject, and search/decision actor. Do not determine the "protagonist" from FK/login/poster alone |
| Units | What counts as one item for persistence, aggregation, uniqueness, editing, deletion, and display. Do not equate bulk UI with one domain record |
| Evidence strength | Distinguish fact, candidate, inference, confirmation, reference, and counterevidence. Do not silently promote internal evaluation into a stronger user claim |
| Counterpart features | Shared experience/contracts and intentional domain differences. Do not force identical internal structure |

Map concepts, evidence, and display expectations into AC and tests. If existing implementation conflicts with the agreed contract, record the current fact; do not delete agreed behavior or reverse tests merely because implementation currently differs.

## What AI applies vs what humans decide

- If an active Policy already determines a correction, AI applies it within authorized scope. Item-by-item inspection is still AI execution work.
- New concepts, ambiguous mapping to existing concepts, or unaccepted risk return to Questions. Do not force a new concept into the nearest existing category.
- "manual review", "individual inspection", or "no bulk replacement" describes the method constraint unless explicitly stated otherwise. Do not reinterpret it as a requirement for human approval of every item.
- Preserve changed IDs, reasons, counterexamples, and verification evidence. Before destructive application to real data, check existing authorization.
- Zero unresolved questions is valid only after required dimensions were actually considered. Do not report "0" as a substitute for investigation.

## Avoid framing errors

Do not compress implementation / DB / framework / file count into a familiar product category first and then infer the product purpose from that category.

First, from concept, human answers, and active ADR, state the short question or promise the product must preserve. Then explain how each relevant structure serves that promise.

A local Pack is an implementation-context minimizer, not a replacement for product meaning. For local Issue work, keep context narrow; when purpose, actors, aggregation units, or display meaning may change, return to the relevant concept / ADR / Policy.

Generic labels such as CRUD, review, recommendation, search, or SNS may be used descriptively, but do not import the category's typical semantics unless they are explicitly accepted here. If AI needs "normally we would..." to invent product meaning, that is a Questions candidate, not an implementation decision.

## Evaluating complexity

Map each structure to the requirement, semantic distinction, or invariant it protects.

A simplification proposal must show a meaning-preserving alternative and explicitly state what properties or operational costs change. Do not call something overengineering merely because of abstraction depth/file count, and do not defend existing complexity merely because it already exists.

Do not use "MVP" or "small project" as a reason to remove necessary semantic distinctions. Persistence units, evidence separation, reverse cases, and display boundaries may be part of the MVP when they are required to test the value hypothesis.

Conversely, complexity with no corresponding meaning/invariant is not justified by history; treat it as a simplification candidate.

Separate future requirements into: extension points needed now, later work, and review triggers. Do not delete an approved extension point without decision, and do not pull future functionality into current Scope.

## Preserving decisions

Store human answers and their revisions in Questions; current AC in the Issue; durable accepted design decisions in ADR; repeatable criteria in Policy. Keep the current 4-point docs aligned and cross-link rather than duplicating full text.

When archives are renamed/removed, preserve a replacement link or immutable revision reachable from the Issue.

Operational progress, offsets, and resume positions belong in Issues or dedicated operations material, not in decision-history Questions.
