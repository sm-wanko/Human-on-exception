# coverage

Generated evidence from `make test`, `make survey`, and `make docs`. Generated files are normally not committed.

- `coverage/tests/summary.md` — aggregate test result
- `coverage/tests/backend-unit.md` — Laravel/PHPUnit Unit suite
- `coverage/tests/sit.md` — Laravel/PHPUnit System (SIT) suite
- `coverage/tests/vitest.md` — frontend Vitest excluding integration tests
- `coverage/tests/vitest-integration.md` — frontend integration tests
- `coverage/survey/` — Flow / SYS / FE / route gaps
- `coverage/docs/` — generated docs / consistency reports

Local test execution is Docker-backed. Run `make up` once if you want the application running interactively; `make test` itself ensures the required services are started.
