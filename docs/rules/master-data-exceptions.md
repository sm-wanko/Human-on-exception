# Master Data Exception Rules

**Principle**: on production paths, avoid hard-coded master labels, seed-ID literals, and manual edits to generated artifacts. Use the DB / API / project-defined Source of Truth.

**This document** lists only intentional exceptions.

---

## 1. Production-path boundary

| Category | Handling |
|---|---|
| production | DB / API / official configuration is authoritative |
| test fixture | do not operate as a production mirror; keep only values needed for contract verification |
| generated artifact | generator/source is authoritative; do not hand-edit |

---

## 2. Exceptions

The current sample `TASK_CRUD` has **no master-data exceptions**.

When adding an exception, add its source of truth, allowed reason, and verification method to this table in the same PR.

| ID | category | source of truth | allowed exception | verification |
|---|---|---|---|---|
| — | — | — | none | — |

---

## 3. URL / constant mappings

None currently.

---

## 4. CI verification

If an exception is added, add drift detection to either `make lint` or `make survey`.

---

## 5. Completion check

- [ ] the exception is genuinely necessary
- [ ] Source of Truth is explicit
- [ ] production data is not managed in two places
- [ ] a drift-detection method exists
