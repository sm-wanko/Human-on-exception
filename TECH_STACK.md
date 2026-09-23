# Technology Stack

Paw-Pads の AI 開発環境を Laravel + TypeScript に置き換えたサンプル。

## Backend

- PHP 8.3
- Laravel 12
- PHPUnit / Orchestra Testbench
- SQLite in-memory（サンプル test）

## Frontend

- Next.js 15.5.2
- React 19.1.1
- TypeScript 5.9.2
- Vitest
- React Testing Library

## 公開コマンド

| コマンド | 用途 |
|---|---|
| `make lint` | Backend / Frontend lint + typecheck |
| `make test` | Backend / Frontend / SIT |
| `make survey` | Flow / SYS / FE / docs gap |
| `make docs` | endpoint docs 更新 |
| `make sit` | Backend System test |
| `make fe-survey` | FE-ID gap |

AI の読む順・SoT・完了条件は [AGENTS.md](./AGENTS.md) を正本とする。
