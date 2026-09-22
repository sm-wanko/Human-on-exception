# Project Conventions

This file is intentionally project-specific.

Human-on-Exception standardizes the **development protocol** around Questions, contracts, tests, review, and escalation. It does **not** prescribe one application architecture.

The Laravel + TypeScript architecture included in this repository is an illustrative example only.

## Right-size the architecture

Adopt architecture that fits the actual project:

- existing codebase and conventions
- expected complexity
- team/agent scale
- performance and operational constraints
- deployment environment
- maintenance horizon

A small service may need fewer layers than the example.
A large system may need stricter module boundaries, generated contracts, dependency guards, or additional services.

Do not copy the sample architecture mechanically.

## Required project rule categories

Before autonomous implementation becomes routine, encode the project's real decisions here or in linked rule files.

### Languages / frameworks

Document chosen languages, frameworks, package managers, supported versions, and framework-specific conventions.

### Layering / dependency direction

State which layers/modules may depend on which, and list prohibited crossings.

### API conventions

Document request/response/error conventions, compatibility rules, schema generation, and versioning expectations.

### Persistence conventions

Document transaction ownership, repository/query boundaries, migration tooling, master/seed ownership, audit fields, and delete policy.

### Frontend conventions

Document state ownership, server/client boundaries, route/context continuity, component layering, and test expectations.

### External-service conventions

Document timeout/retry/fail-open/fail-close behavior, stubbing strategy, and ownership of external contracts.

### Completion commands

List exact lint/test/docs/survey commands required for each touched area.

## Rule

Agents must follow **this project's encoded conventions** before generic ecosystem advice or the sample architecture in this repository.

If project architecture has not yet been chosen and a task would establish a meaningful long-term boundary, create a Question instead of silently adopting the starter's sample architecture.
