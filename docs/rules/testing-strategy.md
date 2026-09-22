# Testing Strategy

## Principle

Humans judge subjective experience. Machines verify objective contracts.

The exact test stack is project-specific, but features should distinguish:

- unit: isolated logic
- integration: one service plus real local dependencies where useful
- system/vertical: request → service(s) → persistence → side effects
- frontend/interaction contract: user action/state/route → expected API/context

UI visual judgment may remain manual unless the project explicitly adopts browser E2E.

## System/vertical test contract

For each applicable `<FLOW_ID>-SYS-NNN`, verify the relevant four dimensions:

1. request contract — method/path/headers/payload
2. response contract — status/body
3. persisted state — rows/relations/transaction result
4. side effects — downstream calls, jobs, cache, history, events

Negative tests should normally assert that unintended persistence and side effects did not occur.

## Test matrix

The Flow document owns the test matrix.

Each planned automated case must have an exact stable ID that appears in the executable test name.

Do not create a fifth per-feature "test spec" document. Keep test planning with the Flow so behavior and verification do not drift apart.

## Arrange vs system under test

Do not make unrelated flows depend on another feature merely to arrange state.

Examples:

- if a review test needs an authenticated user, prefer a test helper/token fixture unless login itself is under test
- if a downstream external service is not the SUT, use a contract-capturing fake/stub where appropriate

This prevents one broken dependency from making the entire suite meaningless.

## External systems

Real third-party OAuth, paid APIs, irreversible webhooks, and similar boundaries may be N/A for normal vertical tests when a deterministic local contract substitute is the correct test surface.

Declare N/A in the Flow matrix with a reason. Do not silently omit it.

## Project adaptation

A real project must document:

- concrete test locations and commands
- environment/seed/reset strategy
- CI split and required checks
- mock/stub policy for each external boundary
- any frontend contract-test strategy

The starter's Task CRUD demonstrates the ID linkage, not every production testing concern.
