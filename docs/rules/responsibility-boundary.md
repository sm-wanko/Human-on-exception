# Human / AI Responsibility Boundary

## Purpose

Human-on-Exception exists to test and operationalize one hypothesis:

> **The human is the scarce coordination resource. Software development should be structured so routine engineering work does not require a human to remain inside the loop.**

The goal is not to remove human judgment.

The goal is to reserve human attention for decisions that only a human can legitimately own, while allowing agents to carry the engineering loop continuously.

---

## Human owns

Humans own decisions that define **purpose and authority**.

### Product / intent

- what should exist
- why it matters
- desired user/business outcome
- priorities between competing product goals
- explicit non-goals

### Boundary decisions

- public behavior that has multiple valid product outcomes
- security/privacy posture when policy is not already fixed
- destructive or irreversible data decisions
- long-lived architecture ownership when no repository rule resolves it
- compatibility tradeoffs that change product/operational intent
- acceptance of risk when the repository cannot decide safely

### Answers

Humans answer Questions only when repository evidence cannot resolve the decision.

A human Answer becomes reusable repository context so the same class of decision should not require repeated human attention.

---

## Human does NOT own by default

A human is not a required participant for:

- locating code, docs, tests, or owners
- choosing files to edit
- reading every diff
- decomposing routine work into Issues
- writing routine implementation code
- selecting ordinary framework mechanics
- writing migrations once data semantics are decided
- creating/updating tests
- synchronizing Flow/UI/Validation/DB docs
- creating Packs/index mappings
- triaging routine reviewer findings
- deciding whether an AI review comment is valid when repository evidence can decide
- fixing valid findings
- rejecting false-positive findings
- rerunning checks
- merging work that satisfies declared merge conditions
- routine refactoring required strictly inside confirmed Issue scope

If an agent asks a human to perform one of these because the agent has not investigated enough, that is a protocol failure.

---

## AI owns

Agents own the engineering process required to turn confirmed intent into a verified repository change.

### Search / context recovery

AI must:

- resolve relevant Pack/Flow/rules itself
- locate implementation/tests/current contracts
- inspect callers/siblings when needed
- determine Source-of-Truth conflicts
- recover prior decisions from ADR/Questions only when rationale matters

### Question generation

AI must:

- separate repository facts from human decisions
- avoid asking about discoverable facts or routine mechanics
- expose real alternatives and consequences
- recommend a direction when repository evidence supports one
- re-evaluate second-order consequences after Answers

### Planning / decomposition

AI must:

- create implementation Issues
- decide one Issue vs Epic based on sequencing/reviewability
- define dependencies and merge order
- preserve protected/out-of-scope behavior
- derive acceptance criteria/tests/docs from confirmed decisions

### Coding

AI must:

- implement within repository architecture/rules
- preserve Source-of-Truth ownership
- update implementation/tests/docs together
- handle ordinary migrations/refactors/mechanics autonomously
- stop only when implementation exposes a genuinely unresolved human boundary decision

### Review

Independent AI reviewer must:

- inspect concrete regression/security/data/contract risks
- widen context beyond the diff when necessary
- suppress preference-only findings

Implementation AI must:

- independently adjudicate every finding
- fix valid findings
- reject false positives with evidence
- escalate only genuinely ambiguous decisions

### Completion / continuity

AI must:

- run required checks
- repair failures within confirmed scope
- update Pack/index/docs/question lifecycle
- merge only when declared conditions are satisfied
- leave the repository easier for the next agent to understand than before

---

## Escalation contract

Escalation is a **decision request**, never a handoff of routine engineering work.

A valid escalation must contain:

1. the unresolved decision
2. repository evidence already inspected
3. why evidence cannot decide
4. materially different options
5. consequence/risk of each
6. AI recommendation, when one is defensible
7. exactly what will continue automatically after the Answer

Invalid escalation examples:

- "Which file should I edit?"
- "Should I add a test?"
- "How should I implement this migration?"
- "Reviewer says X; what do you think?"
- "CI failed; please check."
- "Should I use the existing architecture?"
- "There are many files; which Flow should I use?"

Those are AI responsibilities unless a real human-owned boundary is hidden underneath.

---

## Continuous-development principle

The system should optimize for **human absence from routine cycles**, not for the minimum number of AI mistakes.

Mistakes are expected.

The required property is:

> mistakes are detectable, attributable, correctable, and do not require a human to continuously supervise the loop.

A healthy loop looks like:

```text
Human intent
    ↓
AI search / Questions
    ↓
Human Answer only when necessary
    ↓
AI planning / coding / tests / docs
    ↓
Independent AI review
    ↓
AI adjudication / repair
    ↓
merge
    ↓
repository context improves
    ↓
next feature requires equal or less human attention
```

---

## Human-bottleneck test

The protocol is failing if normal development repeatedly requires the human to:

- identify implementation locations
- clarify already-encoded conventions
- decide routine code structure
- read every PR diff
- arbitrate every reviewer disagreement
- manually remind agents to update docs/tests
- manually coordinate child Issues/branches
- repair agent context drift after every task

The protocol is working when the human can remain mostly at:

```text
Intent → Answer exceptional Questions → observe outcome
```

and the repository carries the rest.
