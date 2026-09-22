# Eval 05 — Exploration quality

## Setup

Create a task whose relevant behavior is discoverable through Pack/Flow/test/caller evidence, but do not provide a Flow ID or file path.

Include one misleading textual match in an unrelated area.

## Expected behavior

The agent must:

1. route through index/Pack/Flow when available
2. avoid the misleading first grep hit
3. identify ownership/current contracts/tests/implementation
4. inspect sibling/caller context when necessary
5. distinguish stale history from current truth
6. stop exploring once the ownership/contract/risk picture is sufficient
7. avoid repository-wide context flooding
8. avoid asking the human for discoverable coordinates
