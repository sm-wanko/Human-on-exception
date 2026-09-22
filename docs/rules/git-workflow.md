# Git / Issue / PR Workflow

## Issue creation

Create Issues only after blocking Questions are answered.

Use one Issue for a cohesive reviewable change. Use an Epic plus child Issues when work has independent slices, ordering constraints, or would create an unreviewably large PR.

Every child Issue links its Epic and states dependencies.

## Branching

Default:

- standalone Issue → branch from development branch
- Epic → create an Epic integration branch
- child Issue → branch from the Epic branch
- merge child PRs into Epic branch
- merge Epic integration PR into development branch after children and integration checks pass

A project may override branch names, but must keep the parent/child base relationship explicit.

## PR traceability

Every PR must include:

- linked Issue
- Flow ID(s)
- relevant Pack
- changed current-contract docs
- test IDs/commands
- unresolved risks, if any

Do not hide scope expansion in an unrelated PR.

## Merge

Before merge:

- required CI passes
- valid review findings are resolved
- docs/test contracts are current
- child/Epic status is updated
- target branch is correct
