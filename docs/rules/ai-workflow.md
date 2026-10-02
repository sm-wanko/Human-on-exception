# AI Execution Contract

## 1. Human and AI responsibilities

**Humans decide intent and boundaries. AI owns execution.**

Humans decide Intent, Scope (in/out), Answers to specification ambiguity, and Risk acceptance. This includes the semantic boundary: what may be treated as the same meaning and what must remain distinct.

AI owns investigation, design, Issue creation, implementation, tests, static analysis, docs, PR/evidence, finding classification, fixes, and re-verification. AI is the execution owner that propagates agreed meaning. It is not the semantic authority that may invent or finalize unagreed meaning.

Human code reading, implementation, and line-by-line code review are neither prerequisites nor required gates in the normal workflow. Optional human review is allowed. The five prompts are entry/resume points, not five mandatory approval gates. Once a stage is already authorized, continue it. Merge, release, or destructive operations must remain within previously agreed permissions.

Return to the human only when, after investigation, purpose/scope still has multiple meaningful interpretations; when an irreversible/destructive action is not yet authorized; when security/privacy/cost risk acceptance is required; or when rules conflict in a way AI cannot resolve.

When asking, show: evidence, why AI lacks authority to decide, impact, options + recommendation, what is blocked, and what will resume after the answer.

Ordinary bugs, test failures, review findings, and implementation details already determined by existing rules are AI responsibilities. Missing permissions or environment access are execution blockers: record them and ask only for the minimum connection/environment decision required. Do not hand implementation or review back to the human.

## 2. Investigation and Questions

Choose the investigation mode from the target state. Do not ask the human to choose when the repository can determine it.

- **Existing-contract mode**: the target already has implementation, tests, feature docs, concept, or accepted decisions. Investigate current facts first, reconstruct missing docs/contracts from implementation and tests, and then create only human-authority Questions.
- **Greenfield mode**: the target has no implementation or accepted feature contract yet. Record that absence as a current fact, use human intent + repository-wide rules + technical constraints to propose the minimum provisional design needed to expose semantic decisions, and create Questions only for meaning/scope/risk decisions AI lacks authority to make.
- If a repository is mixed, apply the modes per affected feature/boundary rather than labeling the whole repository greenfield or brownfield.

Greenfield mode must not fabricate current behavior. Existing-contract mode must not turn missing documentation into a human question when implementation/tests already determine the behavior.

1. Follow AGENTS reading order: core-features → relevant Pack / Flow → tests → implementation → applicable rules. For changes that affect purpose or meaning, follow [domain-decisions](./domain-decisions.md) and read the relevant concept, active ADR, and Policy. Trace related API / DB / UI call sites and counterpart functionality only as needed. For a new feature, AI proposes concept / Pack / Flow / path structure.
2. Record Goal, success conditions, current-state facts with evidence paths/symbols/revision, proposed change, Scope / Non-goals, constraints, and contracts that must remain true. Do not ask humans for facts obtainable from the repository.
3. Separate Risks / Unknowns / Assumptions. A recommendation is not an answer. Never mark an unanswered item as accepted.
4. Ask only about decisions that require human authority. Use stable Q-IDs and include background, concrete examples, effects of each option on UX/data/compatibility, recommendation + reason, and what remains blocked without an answer. Phrase questions so humans can answer without reading code.
5. Use [the template](../templates/questions.md). Question count is not a target. Zero questions is valid when the required dimensions were investigated and the repository/accepted decisions already determine them. Record implementation choices within delegated authority as AI technical decisions.

Every investigation must consider the following. If a dimension is not applicable, record why:

| Dimension | What to verify |
|---|---|
| Intent / boundary | Current scope, required follow-up, explicit non-goals, relation to existing contracts |
| Concepts / meaning | Terms; save/aggregate/display units; fact/candidate/confirmed/reference distinctions; trust boundary; allowed examples and counterexamples; applicable ADR/Policy |
| Actors | Authentication actor, operating actor, owner/manager, experience/record subject, search/decision actor. Do not infer the domain protagonist from login/FK/UI operation alone |
| Unit separation | Whether one UI action, bulk input, one persisted record, uniqueness record, edit unit, and aggregation unit are actually the same. If not, preserve and explain the boundaries |
| Input / uniqueness | Omitted/empty/invalid input, normalization, duplicates, retries, concurrency |
| Create / update | POST vs PUT, rollback on conflict, existing data, flag rollback |
| UX continuity | Entry → selection → create/edit → completion → return; query/context continuity; 0/1/many candidates |
| Failure | Successful empty result vs unauthenticated vs unavailable; fallback; rate limit; timeout |
| Evidence / safety | Authentication, authorization, audit, candidate vs confirmed, history, external cost, irreversibility |
| Cross-cutting | Paired features, public API/generated types/docs, callers and fakes |
| Verification | Positive, reverse, boundary, regression; SYS / FE-ID; commands; reasoned N/A for external boundaries |

## 3. Answers → Issue

Reflect answers by Q-ID without changing the original intent. Record reason and answer source/date/reference. If an answer itself is ambiguous, clarify it; do not invent detail merely to eliminate a follow-up question.

When an answer changes, retain the previous one as superseded and link to the new decision. Do not resurrect archived decisions as current contracts. Update affected Issues, AC, and test plans.

Promote durable design decisions to ADR, repeatable operational criteria to Policy, and agreed purpose/core concepts to concept when needed. AI applies already agreed criteria and returns only new meaning or unaccepted risk to humans.

If implementation blockers are zero, mark Ready. If unresolved items remain, stop only the affected portion and continue independent decided work where safe. A design Issue / Draft may exist, but do not present it as implementation-ready. Deferred work must record reason, resume condition, and a follow-up Issue when needed.

Every Issue must include, in addition to the template:

- Goal, background/facts, Questions revision/Q-IDs and links to answers
- Pack, Flow ID, allowed paths, prohibitions, Scope / Non-goals
- target contract, invariants that must remain true, Risks / Assumptions
- observable AC-IDs (precondition, action, result), including required positive/negative/concurrency/migration paths
- mapping: `Q-ID / decision → AC-ID → SYS / FE-ID or verification method → docs`
- completion `make`, docs update locations, dependencies/order, Epic/child Issue/PR links

AI decides implementation splitting and branch names. Split by contracts/dependencies without changing Scope. When using an Epic, create child branches from the Epic work branch and record integration base/order. After creation, cross-link real URLs and avoid duplicate Issues.

## 4. Implementation → PR

AI plans and implements from the Issue AC and applicable rules, and keeps tests, the 4-point docs, and Pack aligned in the same change series. Return only new specification decisions to Questions. Do not expand allowed scope "while here".

Implementer self-review is optional. It does not replace a separate-context independent review when independent review is required. Follow [ai-review.md](./ai-review.md).

The PR must record Issue, Pack, Flow ID, allowed paths vs actual diff, why the change exists, evidence per AC, commands/results/revision, and reasons for anything not run/failed/N/A. Do not confuse attempted execution with success, or test-ID existence with executed success. Do not hide environment problems by deleting tests or weakening CI.

Even when an aggregate command succeeds, verify each required stage's exit result, target revision, and skip/exclusion state. A historical success report or an aggregate Fail=0 is not completion evidence by itself. If actual behavior and contract differ, fix within authorized scope or record the work as incomplete.

## 5. Completion and merge

- Every AC has verification evidence. 4-point docs, Pack, and required counterpart features are aligned. Gap A = 0 alone is not Done.
- Independent AI review of the target head has run, and no valid or unclassified finding remains. A pre-PR separate-context review counts only when its recorded head is that target head. An external PR-service review counts only when it ran against that same head. Follow [ai-review.md](./ai-review.md).
- Required checks are successful on the target head. Pending/skipped/missing/not-run is not success.
- If merge is already authorized, AI performs it. Prompt 5 is merge authorization for its target PR. Do not hard-code main/develop; inspect the PR base and repository workflow.
- Confirm the actual merge result and update linked Issues / Epic. Do not close an Epic until child Issues and integration verification are complete.

Do not add mandatory human code review to the normal workflow. If existing branch protection requires human approval, do not disable or bypass it; report the concrete mismatch between repository settings and this contract.

## 6. Current-state facts vs target change contract

For current-state investigation, SoT order is `implementation → system test → flow → generated coverage`. Do not delete implementation or tests because an old doc disagrees.

For an agreed change, the target contract comes from Answers / Issue AC plus active decisions. Do not preserve an acknowledged bug merely because implementation is top SoT for current-state facts. Return to decision-making only when old and new contracts cannot be distinguished.

Questions are decision history. After implementation, current behavior lives in code + flow/ui/validation/db; active durable decisions live in ADR / Policy; progress lives in Issue / PR. Do not turn Questions into an Issue-close work log.
