# Autonomy and Continuity

## Goal

Human-on-Exception is successful only if autonomy survives repeated development cycles.

A one-off impressive agent run is not enough.

The repository must accumulate decisions and routing information so later work requires **less rediscovery and no additional routine human coordination**.

## Continuity invariant

Every completed change should improve or preserve:

- current-contract accuracy
- Pack/index routing
- architecture/rule clarity
- executable verification
- durable decision history
- reviewer ability to verify independently

Do not finish a feature in a state that only the agent who implemented it can understand.

## Decision reuse

When a human resolves a durable boundary:

- encode reusable policy in rules/ADR when cross-feature
- encode current behavior in current-contract docs
- leave Questions as history
- do not ask the same decision again on the next feature unless assumptions changed

## Agent self-service expectation

Before escalating, an agent must be able to answer:

- What owns this behavior?
- What is current truth?
- Which rules constrain me?
- Which tests verify it?
- Which decisions are already settled?
- What exactly remains human-owned?

If it cannot answer these, it should investigate further rather than immediately asking the human.

## Autonomy regression

Treat these as regressions:

- increasing dependence on human-provided Flow IDs/file paths
- recurring Questions for previously settled conventions
- Packs becoming stale enough that agents abandon routing
- docs/test drift requiring manual human recovery
- review comments routinely requiring human adjudication
- increasingly large context loads just to make routine edits

## Repository-scale response

As a repository grows, solve autonomy loss with repository mechanisms before adding human coordination.

Prefer:

- better indexes/Packs
- stronger ownership rules
- executable dependency guards
- narrower current-contract docs
- reusable ADR/rules
- automated surveys

over:

- "ask the maintainer"
- mandatory human diff review
- more meetings/checklists for humans

## Desired steady state

The repository should behave as external memory and coordination infrastructure for agents.

Human attention should remain approximately tied to **new product/authority decisions**, not to repository size or implementation volume.
