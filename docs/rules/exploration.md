# Repository Exploration Rule

## Goal

An agent must recover enough context to make a correct decision without flooding itself with the whole repository or asking the human to locate files.

Exploration is successful when the agent can state:

- which feature/bundle owns the behavior
- which current contracts apply
- which executable paths implement them
- which tests verify them
- which project rules constrain them
- whether any material ambiguity actually remains

## Progressive widening

Search in this order.

### 1. Route by known coordinates

Use, when present:

1. Issue / PR references
2. core-feature index
3. Pack
4. Flow ID
5. current four-document set
6. matching tests
7. Pack-listed implementation paths

### 2. Search by responsibility, not only words

If coordinates are missing or stale, search for:

- route/API path
- exported symbol/class/use-case name
- DB table/model
- test ID
- UI route/component
- error/status/message
- neighboring feature with the same responsibility

Do not stop at the first textual match.

### 3. Compare sibling paths

Before changing shared behavior, inspect at least one relevant sibling/caller when it could reveal:

- parity requirements
- intentional asymmetry
- shared contract assumptions
- duplicated logic that must remain consistent
- a hidden caller of an API/read model

### 4. Widen only when evidence conflicts

Read ADRs/history/additional rules only when current sources leave a real question.

Do not read the whole repository "for safety".

## Conflict handling

When implementation, tests, and docs disagree:

1. identify the exact contradiction
2. determine whether one source is demonstrably stale
3. inspect recent/current callers and tests
4. preserve working behavior until intent is established
5. if two materially valid intended outcomes remain, create a Question

Never resolve a contradiction by blindly choosing whichever document is easiest to edit.

## Search stopping condition

Stop exploring and act when all are true:

- owning Pack/feature boundary is known
- affected contracts are known
- implementation/test paths are known
- relevant project rules are known
- no unresolved material human decision remains

More search after this point should be driven by a concrete risk, not anxiety.

## Failure mode to avoid

A local grep result is not architectural evidence.

The agent must not:

- edit the first matching file without checking ownership
- assume similar names imply shared semantics
- create a generic abstraction before checking sibling differences
- ask the human for a path/Flow ID that the repository can resolve itself
