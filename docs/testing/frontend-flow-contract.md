# Frontend Flow Contract 規約

**関連**: [system-test-strategy.md](../rules/system-test-strategy.md)（SIT / FE 境界） | [docs/flow/](../flow/README.md)（FLOW-ID マトリクス正本）

---

## 1. 目的とスコープ

### 1.1 目的

ユーザー導線における **context continuity** を、高速な自動テストで保証する。

検証対象は UI snapshot ではない。route・選択状態・詳細遷移等、「画面を跨いだ状態」が途切れないこと。

### 1.2 対象（コア導線のみ）

次に該当する flow に限定して `*-FE-*` を置く。

- list → detail 等の route continuity
- query / context を引き継ぐ導線
- edit/new 等の分岐
- 過去に不具合が出た、または出やすい分岐

### 1.3 対象外

- 単純な静的 UI・レイアウト確認
- snapshot 中心
- ブラウザ E2E 全面網羅

### 1.4 Backend SIT との役割分担

| 層 | ID | 検証すること |
|---|---|---|
| **SIT** | `<FLOW>-SYS-*` | API 契約・DB 状態・縦串 |
| **FE Contract（pure）** | `<FLOW>-FE-*` | 分岐・URL・context 維持 |
| **FE Integration（代表）** | 同上 ID | 操作 → 遷移・API 呼び出し（代表 cell） |

FE は SIT を置き換えない。

---

## 2. 基本原則（MUST）

1. **resolver 化しないと continuity test を増やさない**  
   Presentation / hook に分岐ロジックを足したまま matrix を増やさない。先に `lib/<domain>/` へ pure 関数を抽出する。

2. **contract と integration を分離**
   - contract: DOM なし・高速・matrix 全件可
   - integration: RTL 等・代表導線のみ

3. **matrix 全件 integration は禁止**

4. **FLOW-ID / docs / fixture / test を 1:1**
   - 正本: `docs/flow/<機能>.md` の Frontend 契約マトリクス
   - `it('<FLOW>-FE-NNN: …')` の ID は完全一致

5. **docs を flow contract の正本として扱う**  
   実装変更時は同一変更系列で docs マトリクス・test・resolver を更新。

6. **実装と docs は常に同一変更系列（MUST）**

7. **UX 判断が絡むときは推測実装しない（Question 必須）**  
   仕様が docs に無い、または continuity の正解が複数ある場合は実装前に Question を出す。

### 2.1 Question 必須条件（推測実装禁止）

| 状況 | 対応 |
|---|---|
| `docs/flow` / `docs/ui` に該当分岐・期待 URL が無い | Question → 合意後に docs マトリクス行 |
| continuity の正解が複数あり UX で決める必要がある | Question（オプション提示） |
| 技術的には自然だが UX 文脈を壊しうる | Question |

Question の記録先:

- GitHub Issue 本文・コメント — 進捗の正本
- `docs/testing/questions/*.md` — **起票前 QA の Archive**

---

## 3. 二層アーキテクチャ

```text
docs/flow/{機能}.md
        │
        ├─► lib/{domain}/*Flow.ts
        │         │
        │         └─► *.contract.test.ts
        │
        └─► features/**/**.integration.test.tsx
```

### 3.1 Contract 層（pure）

**配置**: `apps/frontend/src/lib/<domain>/**/*.contract.test.ts`

**禁止**: `render()`、snapshot、CSS class assert。

### 3.2 Integration 層（代表）

**配置**: `apps/frontend/src/features/<domain>/**/*.integration.test.tsx`

全 cell を RTL で回さない。

---

## 4. ディレクトリ構成

```
apps/frontend/src/
├── api/
├── lib/
│   └── task/
├── hooks/
│   └── task/
├── features/
│   └── task/
├── test/
│   └── fixtures/
└── types/
```

---

## 5. FLOW-ID 運用

### 5.1 形式

- **`<FLOW_ID>-FE-<NNN>`**
- FLOW_ID は `docs/flow/<機能>.md` と同じ
- NNN は 3 桁

### 5.2 docs マトリクス（正本）

| 列 | 内容 |
|---|---|
| ID | `TASK_CRUD-FE-001` |
| 操作 | ユーザー操作 |
| 入力・前提 | matrix cell |
| 期待 | route / state / API |
| 備考 | test file |

SYS と FE は同じ Flow 内で隣接させる。

### 5.3 テストでの必須表記

```typescript
it('TASK_CRUD-FE-001: 一覧から詳細IDを渡す', () => {
  // ...
})
```

### 5.4 実装との Source of Truth 順

[AGENTS.md](../../AGENTS.md) に従い、矛盾時は **implementation > system test > docs/flow**。

---

## 6. Fixture / Matrix 方針

全直積は取らない。product 上必要な cell のみ docs に列挙する。

---

## 7. Resolver 分離方針

次のいずれかが Presentation / hook にある場合、先に抽出する。

- route 分岐
- path 生成
- context encode/decode
- edit/new 判定
- 成功後 redirect

Placement: `apps/frontend/src/lib/<domain>/`。

---

## 8. Coverage 可視化方針

`make fe-survey` で docs `*-FE-*` と contract/integration test 名の差分を確認する。

Gap:
- A: docs にあるが test がない
- B: test があるが docs にない

---

## 9. サンプル TASK_CRUD

| FE-ID | 内容 |
|---|---|
| `TASK_CRUD-FE-001` | 一覧 loading |
| `TASK_CRUD-FE-002` | empty |
| `TASK_CRUD-FE-003` | API error |
| `TASK_CRUD-FE-004` | 一覧から detail id を渡す |

---

## 10. 新規 FE-ID 追加チェックリスト

- [ ] §2.1 の観点で Question 不要を確認
- [ ] `docs/flow/<機能>.md` に行追加
- [ ] resolver を `lib/` に実装
- [ ] `*.contract.test.ts` に同 ID
- [ ] 必要な代表 integration のみ更新
- [ ] `docs/ui/<機能>.md` 追従
- [ ] 同一 PR で提出
