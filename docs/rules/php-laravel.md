# PHP / Laravel Quick Rules

**Scope**: the Laravel sample only. Adopting repositories may replace these rules.

These rules are intentionally concrete so an agent does not reinterpret architecture on each Issue.

## MUST NOT

- Controller contains business decisions or Eloquent feature queries
- Application/use-case depends on Laravel HTTP Request/Response
- Application depends on concrete Infrastructure implementation
- Infrastructure returns HTTP responses
- Eloquent model is exposed directly as a public API contract
- one universal DTO/read model is widened for every caller
- generic `Repository<T>` abstraction is introduced across unrelated features
- interface is created only because "Clean Architecture" suggests one
- unrelated refactor/abstraction is mixed into an Issue
- exceptions/errors are swallowed without an explicit contract decision
- destructive migration is introduced without the Question/migration-safety process
- docs alone are used as a reason to delete current implementation/tests

## Responsibility table

| Area | Owns | Must not own |
|---|---|---|
| Route/Controller | binding, auth handoff, HTTP mapping | business rules, SQL/Eloquent feature queries |
| FormRequest | HTTP input normalization/validation | use-case orchestration |
| Application UseCase | orchestration, business/application decisions, multi-write Tx boundary | HTTP framework objects, concrete DB adapter |
| Application Port | dependency contract actually required by use cases | generic framework-wide repository abstraction |
| ReadModel | caller-shaped output such as Quick/Detail | persistence/framework behavior |
| Infrastructure | Eloquent/SQL/external client implementation | product decisions, HTTP response mapping |
| Eloquent Model | persistence mapping | public API contract |

## Flow

```text
HTTP → Controller → Application UseCase → Application Port
                                      ↑
                           Infrastructure implements
```

A Domain layer is optional and should exist only when real domain invariants/behavior justify it.

## API

- public request/response/status/error shape is a contract
- changing it requires Flow/Validation/test updates
- normalize/validate input before Application
- do not let Eloquent serialization define the API accidentally
- keep Quick/list and Detail projections distinct when their data needs differ

## Query / persistence

- query shape follows use-case/read-model needs
- list queries should not load detail-only columns/relations without reason
- avoid N+1
- use framework binding/query APIs; raw SQL must be parameterized
- repository/infrastructure owns persistence mechanics
- source-of-truth ownership for seed/master data must be explicit before editing it

## Transactions

- one simple persistence operation does not need ceremony-only explicit Tx
- Application owns an explicit transaction when multiple writes must succeed/fail atomically
- non-DB side effects must not be falsely presented as part of a DB atomic transaction
- rollback/failure semantics belong in DB/Flow tests when material

## Errors

- Infrastructure errors are translated at the appropriate Application/HTTP boundary
- do not make HTTP status decisions inside Infrastructure
- expected not-found/conflict behavior must be explicit in Validation/Flow

## Migrations

Routine SQL/framework mechanics are agent-owned.

Escalate only unresolved product/compatibility decisions such as:

- destructive deletion
- irreversible semantic transformation
- dual-read/write rollout
- downtime vs compatibility
- ownership/source-of-truth relocation

Follow `migration-safety.md`.

## Verification

For affected Flow IDs:

- normal path
- negative validation/not-found/conflict path
- persisted state
- rollback/no unintended mutation
- external/cache/job effects if applicable

Real projects must add their actual Composer/PHPStan/Pint/Pest/PHPUnit commands to project conventions.
