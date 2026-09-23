# System Integration Test 方針

## 概要

このドキュメントは、`apps/backend/tests/System/` 配下に置く **System Integration Test（SIT）** の思想・用語・運用ルールを定義する。

SIT のゴール:

- **人 = UI 違和感の確認**（手動・主観領域）
- **機械 = 全通信パターン + DB 状態 + 跨境界契約の網羅**（自動・客観領域）

「ブラウザ E2E」ではなく **HTTP → Laravel → DB** の縦串を API 契約と DB 状態で自動検証する。

### MUST: docs・実装・SIT の三者整合

- Docs は [docs-follow.md](./docs-follow.md)
- N/A は [docs-na-conventions.md](./docs-na-conventions.md)
- Flow マトリクスのすべての `<FLOW>-SYS-NNN` は test 名 / data provider 名から抽出可能にする

## 1. テスト戦略の3層

| 層 | 配置 | 責務 | 道具 |
|----|------|------|------|
| unit | `apps/backend/tests/Unit/` | ロジック単体 | PHPUnit |
| integration / feature | `apps/backend/tests/Feature/` | Laravel + 実 DB | PHPUnit / Laravel test |
| **system** | **`apps/backend/tests/System/`** | **HTTP → Laravel → DB 縦串** | PHPUnit / Laravel |
| frontend 契約（API） | `apps/frontend/src/**/*.integration.test.tsx` | 補助：操作 → API 呼び出し | Vitest + RTL |
| **frontend flow contract** | `apps/frontend/src/lib/**/*.contract.test.ts` | 補助：route / state / context continuity | Vitest（pure resolver） |

**主役は system**。Frontend は補助。永続化・DB 副作用は Backend 側で担保する。

Frontend Flow Contract の正本は [`docs/testing/frontend-flow-contract.md`](../testing/frontend-flow-contract.md)。

### 1.1 Frontend 契約テスト（API 呼び出し）の境界

Frontend integration は「期待した API が method / URL / payload で呼ばれるか」を補助的に検証する。DB 状態・跨サービス副作用は対象外。

### 1.2 Frontend Flow Contract

コア導線の分岐・route・context は pure resolver + `*-FE-*` で保証する。

---

## 2. Flow ID

- 正系: `<FLOW>-SYS-001`〜`099`
- 逆系: `<FLOW>-SYS-101`〜`199`
- FE: `<FLOW>-FE-NNN`

Flow ID は `docs/flow/<機能>.md` のマトリクスとテスト名で完全一致させる。

---

## 3. SIT が検証するもの

正常系:

1. request（method / path / payload）
2. response（status / body）
3. DB 状態
4. side effect（該当時）

逆系:

- status / body
- **意図しない DB write が無い**
- side effect が発火していないこと（該当時）

---

## 4. 認証・監査

会員向け mutation を追加・変更する場合は [audit-ui-persistence.md](./audit-ui-persistence.md) に従い、正常系 SIT で監査値を assert する。

### 4.1 監査 assert

- `created_by` / `created_app`
- update 時 `updated_by` / `updated_app`
- seed / migration 由来は対象外

認証 N/A の Flow は flow / validation で N/A を明示する。

---

## 5. 外部境界

有償 API / OAuth / 実メール等、決定論的ローカル縦串にできない経路は flow マトリクスで理由付き N/A とする。stub 可能なら request contract を検証する。

---

## 6. Frontend との境界

- 全 UI matrix を RTL で回さない
- pure な分岐は contract
- 代表 user interaction は integration
- DB / 永続化は system

---

## 7. 完了

- `make test`
- flow / SYS / FE を触ったら `make survey`
- Gap がある場合は「未実装」か「N/A」かを明示する
