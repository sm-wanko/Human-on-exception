# Backend Quick Rules (Always Read)

**Scope**: `apps/backend/` only.  
**AI**: this file is authoritative for everyday backend work. Open [backend-coding-conventions.md](./backend-coding-conventions.md) only for detailed examples/background.

| Situation | Read |
|---|---|
| Backend implementation/fix | **this file** |
| Tx / migration / PHPDoc / middleware detail | [backend-coding-conventions.md](./backend-coding-conventions.md) |
| Why/background | same detailed conventions |

---

## 1. MUST NOT

- put business logic in Controllers; branching/normalization decisions belong in Service
- let Service directly use Eloquent / DB facade; use Repository
- put business decisions in Repository
- instantiate Service / Repository inside Controller; use constructor injection
- put business logic in `bootstrap/` or route definitions; wiring only
- concatenate SQL strings; use Query Builder / bindings
- omit timeout for external APIs
- hard-code timeout values; use config
- place code in an unrelated domain Service/Repository merely because it is adjacent; place by **ownership**
- ignore errors
- delete existing implementation/tests based only on docs; current-state SoT is implementation → test → flow

---

## 2. Layer responsibilities

| Layer | MUST | MUST NOT |
|---|---|---|
| **Controller** | bind input, forward auth context, map HTTP status / Resource | business logic, DB |
| **Service** | rules, orchestration, exception normalization | Eloquent/raw SQL, HTTP Response |
| **Repository** | Query Builder/Eloquent persistence | business decisions, HTTP |
| **DTO / Resource** | API DTO / read model | DB mutation, domain decisions |
| **Model** | DB/domain model | API-specific response assembly |
| **FormRequest** | HTTP input validation | business decisions |

**Flow**: `Request → Controller → Service → Repository → Model` with DTO/Resource for API/read models.

---

## 3. Placement by ownership

- `app/Http/Controllers/{Domain}`
- `app/Services/{Domain}`
- `app/Repositories/{Domain}`
- `app/Models`
- `app/DTO/{Domain}` / `app/Http/Resources/{Domain}`
- `app/Http/Requests/{Domain}`
- Do not force Repository split to one table = one class. Group by common reason to change.
- Split oversized code by responsibility.

---

## 4. Errors

- Repository: do not leak raw DB/framework exceptions to UI.
- **Service**: normalize into application exceptions for Controller.
- Controller: status/response mapping only.
- Service owns semantic mapping such as not-found/conflict.

---

## 5. DB / SQL / audit

- **Query**: use-case specific. If list/detail need different columns/JOINs, separate them.
- **Tx**: a simple single-Repository write may stay inside Repository. Service owns `DB::transaction` when multiple Repository/write operations need one atomic boundary.
- **Migration**: Laravel migration is authoritative for schema change. Do not rewrite the meaning of an existing migration after the fact; add a new migration.
- **Audit**: member-facing write paths follow [audit-ui-persistence.md](./audit-ui-persistence.md).

---

## 6. Context / timeout

- Pass only needed auth/request-id values from Controller to Service.
- External APIs use Laravel HTTP Client or equivalent with config-injected timeout.
- Queue/Job payloads preserve the same ownership boundaries.

---

## 7. Logging

- Use Laravel logger / Log facade.
- Use structured context such as `action`, `member_id`, `task_id`.
- Do not swallow errors.

---

## 8. PHPDoc — MUST

- Touched public/exported-equivalent classes/methods: document non-obvious responsibility, inputs/outputs, and side effects.
- **Do not** write comments that only point to docs/flow or repeat legacy/Wave/document metadata.
- Flow / Validation remains authoritative for API contracts. Do not copy the whole specification into comments.

---

## 9. Naming

- class: PascalCase; method/property: camelCase; DB/JSON: snake_case
- `XxxService`, `XxxRepository`, `XxxRequest`, `XxxResource`
- Do not confuse Model with API DTO/read model.

---

## 10. Tests / completion

| Location | Purpose |
|---|---|
| `tests/Unit/` | isolated logic |
| `tests/Feature/` | HTTP + Laravel + DB |
| `tests/System/` | vertical SIT; see [system-test-strategy.md](./system-test-strategy.md) |

**Before backend completion**: root `make lint` → `cd apps/backend && make test`. For structure/flow changes also run `make survey`.
