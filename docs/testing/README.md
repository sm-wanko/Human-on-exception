# docs/testing（テスト戦略・規約 · Archive）

**置くもの**: FE Flow Contract の**規約**、束の**索引**、Issue 起票前の Questions、**経緯・着地の Archive**。  
**置かないもの**: いまの仕様の写し（それは code · 4 点セット）· survey 成果物 · Issue 進捗サマリ。

SIT の正本: [`docs/rules/system-test-strategy.md`](../rules/system-test-strategy.md)

---

## 事実と経緯（MUST）

| | 置き場 | 書いてよいこと |
|--|--------|----------------|
| **事実** | ソースコード · `docs/flow` / `ui` / `validation` / `db` | いまの契約・手順・API・画面・SQL |
| **経緯** | 本ディレクトリの `questions/` · `adr/` | なぜそうなったか、旧案、着地 Issue（questions は依頼者×AI の要件定義 Archive のみ） |

**4 点セットに経緯は書かない。**

---

## 作業フロー（人間 → AI → Issue → PR）

```text
やりたいこと（人間）
  → Questions 潰す（AI / 人間 · 必要なら questions/ に Archive）
  → Issue 起票（1 テーマ = 1 Issue）
  → 実装 + テスト + docs（コミット分離）
  → PR 前: 実装 === docs の確認
  → PR（関連 Issue 紐づけ必須）
  → 別人格 AI レビュー
  → 実装 AI が指摘を判定・修正
  → マージ · Issue Close
```

| 段階 | 正本 | `docs/testing` の役割 |
|------|------|------------------------|
| **Questions** | Issue 本文 +（任意）`questions/*.md` | **起票前に** UX / 設計の未決を潰す Archive |
| **Issue** | GitHub Issue | スコープ · DoD · `Closes #n` 先 |
| **実装の今** | code → SIT → **`docs/flow` 等 4 点** | 規約は [`frontend-flow-contract.md`](./frontend-flow-contract.md) |
| **進捗** | Issue Open/Close · PR | **リアルタイム更新しない** |

### PR / Issue ルール（MUST）

| ルール | 内容 |
|--------|------|
| **1 Issue = 1 PR** | 1 テーマ 1 ブランチ 1 PR。チェーン分割は **Issue 本文**に書く |
| **コミット分離** | **実装** · **テスト** · **docs** を別コミット（同一 PR 内） |
| **PR 前チェック** | **実装 === docs**（触った `docs/flow` の `*-FE-*` / `*-SYS-*` とテスト名 1:1、必要なら `make survey`） |
| **PR 紐づけ** | PR 本文 `Closes #n` 等で関連 Issue を必ずリンク |
| **検証** | 触った範囲の `make lint-*` / `make test-*`（構造変更時 `make survey`） |

---

## `questions/` とは

**Issue 起票前の Questions**と、合意後の **経緯 Archive**。

「questions を開けば最新仕様がわかる」想定にしない。

---

## `adr/` とは

**いま有効な設計決定**（Architecture Decision Record）。`questions/` と同階層。

---

## ドキュメント一覧

| パス | 内容 |
|------|------|
| [core-features.md](./core-features.md) | コア機能 × Flow 束 × pack |
| [bundle-completion.md](./bundle-completion.md) | 束 Done 定義 |
| [frontend-flow-contract.md](./frontend-flow-contract.md) | FE Flow Contract 規約 |
| [questions/](./questions/) | 起票前 QA Archive |
| [adr/](./adr/) | 有効な設計決定 |
| [`docs/rules/system-test-strategy.md`](../rules/system-test-strategy.md) | SIT |
