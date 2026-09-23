# AI Agent Rules（Human-on-Exception）

**対象**: Cursor / Claude Code / CodeX のみ。日本語でレビュー・応答すること。

**機能索引**: [`docs/testing/core-features.md`](./docs/testing/core-features.md) → [`docs/ai/packs/`](./docs/ai/packs/)（パス列挙 + Flow ID + 完了 `make` のみ。flow 本文コピー禁止）。

---

## 読む順（最小）

0. **コア機能の束**: [`docs/testing/core-features.md`](./docs/testing/core-features.md)（該当 pack・Flow ID の索引）
1. **Issue / PR** の Flow ID・触ってよいパス・禁止（Issue 起票前は依頼内容から該当束を自力で特定する）
2. **該当 1 本だけ**: `docs/flow/<機能>.md`（Scope とマトリクス行。4 点セットはその機能に限り必要なら）
3. **対応テスト**: 同 Flow の `*-SYS-*` → `apps/backend/tests/System/`、`*-FE-*` → `apps/frontend/src/**/*.contract.test.ts` / `*.integration.test.tsx`
4. **実装ファイル**: Issue / PR または `docs/ai/packs/<bundle>.md` のマニフェスト
5. **規約**: BE/FE は `docs/rules/backend-quick.md` / `frontend-quick.md`（常時）。詳細例のみ `*-coding-conventions.md`

## 読まない（初期探索で避ける）

- `coverage/docs/*`（`make docs` 生成物。gitignore）
- `docs/flow/` の全ファイル横断 grep
- `TECH_STACK.md` / `README.md` 全文（コマンド・環境は不明時だけ該当節）
- `docs/rules/*` の全読み（触った領域の規約だけ、必要な節を参照）

---

## 必須（毎タスク）

1. 上記 **読む順 0→5** でコンテキストを取る（flow は **該当 1 本**、pack は該当束のみ）。
2. Issue / PR を起票・作成するときは **Pack**・**Flow ID**・**触ってよいパス**・完了時 **`make`** を必ず含める。
3. 完了前に下表どおり `make lint-*` / `make test-*`（構造変更時は `make survey` 等）。触った exported には PHPDoc / JSDoc MUST。
4. 検証は `make` または各 app の既存コマンドを使う。ad-hoc な別環境を正本にしない。

## 完了条件

| 変更範囲 | 最低限 | 構造・docs 触ったとき |
|----------|--------|------------------------|
| Backend | ルート `make lint` → `cd apps/backend && make test` | 同上 + `make survey`（該当 flow） |
| Frontend | ルート `make lint` → `cd apps/frontend && make test` | flow / route 変更時 `make survey` / `make docs` |
| 横断 | `make test` | `make survey` / `make docs` |

---

## Source of Truth（矛盾時）

1. implementation → 2. system test → 3. `docs/flow` → 4. `coverage/*`（生成物）

**docs のみ**を根拠に既存実装・テストを削除しない。

**事実**は code · 4 点セット（flow / ui / validation / db）。**経緯**は [`docs/testing/questions/`](./docs/testing/questions/) · [`docs/testing/adr/`](./docs/testing/adr/)。4 点セットに経緯は書かない。

---

## 禁止（依頼なく変更しない）

- API 仕様（パラメータ・レスポンス）
- ビジネスロジックの追加・削除・変更
- 認証・CORS・セキュリティ設定の削除
- レイヤー構造の書き換え、Laravel bootstrap / route 配線へのビジネスロジック追加
- flow で N/A とした外部境界を「完成」扱い

---

## 規約（必要時のみ該当ファイルを開く）

| 触った領域 | 参照 |
|------------|------|
| Laravel Backend | [`docs/rules/backend-quick.md`](./docs/rules/backend-quick.md)（常時）。詳細のみ [`backend-coding-conventions.md`](./docs/rules/backend-coding-conventions.md) |
| Frontend | [`docs/rules/frontend-quick.md`](./docs/rules/frontend-quick.md)（常時）。詳細のみ [`frontend-coding-conventions.md`](./docs/rules/frontend-coding-conventions.md) |
| flow / docs 追従 | [`docs/rules/docs-follow.md`](./docs/rules/docs-follow.md) |
| N/A 表記 | [`docs/rules/docs-na-conventions.md`](./docs/rules/docs-na-conventions.md) |
| SIT / FE Contract | [`docs/rules/system-test-strategy.md`](./docs/rules/system-test-strategy.md), [`docs/testing/frontend-flow-contract.md`](./docs/testing/frontend-flow-contract.md) |
| 会員向け mutation の監査 | [`docs/rules/audit-ui-persistence.md`](./docs/rules/audit-ui-persistence.md)（正本） |
