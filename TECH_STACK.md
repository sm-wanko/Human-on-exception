# Technology Stack

AI が実装・検証を担う開発フローの Laravel + TypeScript サンプル。

## Local

- Docker Compose V2
- PostgreSQL 15

## Backend

- PHP 8.3
- Laravel 12
- PHPUnit / Orchestra Testbench
- PostgreSQL（Docker local）
- SQLite in-memory（test）

## Frontend

- Next.js 15.5.2
- React 19.1.1
- TypeScript 5.9.2
- Vitest
- React Testing Library
- pnpm 10.13.1

## Makefile ターゲット台帳

| コマンド | 用途 |
|---|---|
| `make build` | Docker image build |
| `make up` | Frontend / Backend / PostgreSQL 起動 |
| `make down` | local services 停止 |
| `make logs` | compose logs |
| `make init-db` | Laravel migration |
| `make reset-db` | local DB fresh migration |
| `make lint` | Backend / Frontend lint + typecheck |
| `make test` | Backend / Frontend / SIT |
| `make survey` | Flow / SYS / FE / docs gap |
| `make docs` | endpoint docs 更新 |
| `make sit` | Backend System test |
| `make fe-survey` | FE-ID gap |

AI の読む順・SoT・完了条件は [AGENTS.md](./AGENTS.md) を正本とする。
