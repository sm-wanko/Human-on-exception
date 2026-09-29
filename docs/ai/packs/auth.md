# Pack: auth

ログインの 1 束。Flow ID: `AUTH_LOGIN`。

意味の入口: [本人の Task](../../concept/owned-task.md)。決定: [ADR-001](../../testing/adr/001-self-registered-account.md)。

## 束の境界（docs）

| 含む | 含まない（別束） |
|------|------------------|
| 本人登録 | Task の項目変更 |
| ログイン / ログアウト / 表示名 | パスワード再設定メール |
| users | OAuth |

## 4 点セット

| 観点 | doc |
|------|-----|
| flow | [ログイン.md](../../flow/ログイン.md) |
| ui | [ui/ログイン.md](../../ui/ログイン.md) |
| validation | [validation/ログイン.md](../../validation/ログイン.md) |
| db | [db/ログイン.md](../../db/ログイン.md) |

## 束完了チェックリスト

**テスト Gap A = 0 のみでは Done にしない。**

### ドキュメント

- [x] 4 点セット存在
- [x] flow Scope
- [x] FE / SYS マトリクス

### pack

- [x] 本ファイル

### Frontend

- [x] `AUTH_LOGIN-FE-001`〜`003`
- [x] 登録 / ログイン Presentation と表示名

### Backend（SIT）

- [x] `AUTH_LOGIN-SYS-001` `002` `003` `004`

## Frontend（実装パス）

| ファイル | 役割 |
|----------|------|
| `apps/frontend/src/api/auth.ts` | API |
| `apps/frontend/src/lib/auth/` | 表示名と失敗文言 |
| `apps/frontend/src/hooks/auth/` | session |
| `apps/frontend/src/features/auth/` | Presentation |

## Backend（実装パス）

| ファイル | 役割 |
|----------|------|
| `apps/backend/app/Http/Controllers/AuthController.php` | HTTP |
| `apps/backend/app/Services/Auth/AuthService.php` | 登録と照合 |
| `apps/backend/app/Repositories/Auth/UserRepository.php` | persistence |
| `apps/backend/tests/System/AuthLoginSystemTest.php` | SYS-ID |

## 完了コマンド

```bash
make lint
make test
make survey
```

## 禁止

- Task の schema と認可の変更
- 平文パスワード
- 外部メールと OAuth
