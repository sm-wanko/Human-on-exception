# Migration Safety

Migrations are implementation mechanics, but data-loss and compatibility choices are human-boundary decisions when the repository does not already define them.

## Before writing a migration

Inspect:

- current schema and data ownership
- callers/readers/writers
- seed/master-data source of truth
- rollback/forward-fix expectations
- deployment ordering constraints

## Do not ask the human about routine SQL mechanics

The agent should choose ordinary indexes, constraint syntax, migration filenames, and compatible implementation details according to project conventions.

## Escalate when unresolved

Create/extend Questions when a migration may require a product/boundary decision such as:

- destructive data deletion
- irreversible semantic transformation
- downtime vs online compatibility tradeoff
- temporary dual-read/dual-write behavior
- externally visible compatibility break
- source-of-truth relocation with competing valid ownership models

## Verification

Migration changes should be covered by the strongest practical combination of:

- clean initialization
- upgrade from previous schema
- constraints/indexes
- application integration/system tests
- seed/master-data integrity checks

Project-specific database rules belong in a domain rule or Pack.
