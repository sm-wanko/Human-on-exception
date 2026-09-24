# Architecture Decision Records（`docs/testing/adr/`）

**置くもの**: 実装に残す **設計決定**（Accepted / Superseded）。  
**置かないもの**: 未決の議論（→ [`questions/`](../questions/)）、画面・API 詳細（→ `docs/flow`）。

`questions/` と同階層。起票前 QA の Archive と分離し、「いま有効な決定」だけをここに集約する。

---

## 書き方（短く）

- **いま有効な決定だけ**。Accepted / Superseded。
- **書かない**: 作業 HISTORY、画面/API 手順。
- 未決 → `questions/`。
- 1 ADR = 1 決定テーマ。

### 構成

1. 背景 / きっかけ
2. 検討した選択肢
3. 決定事項（設計の骨だけ）
4. 決定理由 / トレードオフ
5. 影響・前提・見直し条件
6. 関連（flow / questions）

目的・用語は [concept](../../concept/README.md)、反復作業の具体的基準は [Policy](../policy/README.md) を参照する。ADRには選択理由と見直し条件を残し、運用基準を重複管理しない。判断主体と回答の出所を明記し、人間が回答していない案を Accepted にしない。
