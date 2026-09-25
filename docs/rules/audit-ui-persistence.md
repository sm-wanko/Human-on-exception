# Audit for Member-Facing Persistence

This is the source of truth for audit columns (`created_by` / `created_app` / `updated_*`) on **member-facing mutations** initiated from UI or authenticated APIs.

Tool-specific hooks: [`.cursor/rules/01-audit-ui-persistence.mdc`](../../.cursor/rules/01-audit-ui-persistence.mdc), [`.github/copilot-instructions.md`](../../.github/copilot-instructions.md).

---

## MUST — implementation

- **Controller**: obtain the authenticated user/member ID and pass it into the Service.
- **Service**: pass mutation actor / app / action to the Repository through the project's audit context/value.
- **Repository (write path)**: bind audit values into DB writes. Do not ad-hoc hard-code values such as `"USER"` or `"system"` on member-facing paths.

For Laravel, the project's existing Audit DTO / ValueObject / observer mechanism is authoritative. Do not introduce a parallel audit mechanism without an explicit decision.

## MUST — SIT

- New or changed member-facing mutations must assert DB audit values on the positive path according to [system-test-strategy.md](./system-test-strategy.md) §4.1.
- Rows originating from migration / seed / fixtures are outside UI-path audit requirements.

## Tables without audit columns

Do not add a migration to junction tables or similar solely because of this rule when the schema intentionally has no audit columns. Track through the parent record or existing audit mechanism.

## Sample TASK_CRUD

Authentication itself is outside Flow Scope, so audit is N/A. State this explicitly in `docs/validation/タスクCRUD.md` / `docs/db/タスクCRUD.md`.
