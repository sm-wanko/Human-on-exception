# Architecture Decision Records (`docs/testing/adr/`)

## English

**Store**: durable **design decisions** that remain in the implementation, with status Accepted / Superseded.  
**Do not store**: unresolved discussion → [`questions/`](../questions/), or detailed screen/API behavior → `docs/flow`.

ADR is separate from pre-Issue Q&A history. Keep only decisions that are currently valid or explicitly superseded.

### Keep ADR concise

- only active/superseded decisions
- no work-history log or screen/API procedure
- unresolved items belong in Questions
- one ADR = one decision theme

Recommended structure:

1. Context / trigger
2. Options considered
3. Decision — design skeleton only
4. Reason / trade-offs
5. Impact, assumptions, review triggers
6. Related flow / Questions

Purpose/terminology belongs in [concept](../../concept/README.md). Repeatable operational criteria belong in [Policy](../policy/README.md). ADR stores why a choice was made and when it should be reconsidered; do not duplicate Policy.

Record who had decision authority and the answer source. Do not mark an AI-generated proposal Accepted when no human answer/authority exists.

### Active

| ADR | Theme |
|---|---|
| [001](./001-self-registered-account.md) | self-registered account and display name |
| [002](./002-task-status-and-logical-delete.md) | STATUS versus checkbox logical delete |
| [003](./003-task-dates.md) | registration date and inert due date |
| [004](./004-task-owner-isolation.md) | owner-only tasks, 404, retain ownerless rows |

## 日本語

**置くもの**: 実装に残す **設計決定**（Accepted / Superseded）。  
**置かないもの**: 未決の議論（→ [`questions/`](../questions/)）、画面・API 詳細（→ `docs/flow`）。

`questions/` と同階層。起票前 QA の Archive と分離し、「いま有効な決定」だけをここに集約する。

### 書き方（短く）

- **いま有効な決定だけ**。Accepted / Superseded。
- **書かない**: 作業 HISTORY、画面/API 手順。
- 未決 → `questions/`。
- 1 ADR = 1 決定テーマ。

構成:

1. 背景 / きっかけ
2. 検討した選択肢
3. 決定事項（設計の骨だけ）
4. 決定理由 / トレードオフ
5. 影響・前提・見直し条件
6. 関連（flow / questions）

目的・用語は [concept](../../concept/README.md)、反復作業の具体的基準は [Policy](../policy/README.md) を参照する。ADRには選択理由と見直し条件を残し、運用基準を重複管理しない。判断主体と回答の出所を明記し、人間が回答していない案を Accepted にしない。

### 有効な決定

| ADR | テーマ |
|---|---|
| [001](./001-self-registered-account.md) | 本人登録と表示名 |
| [002](./002-task-status-and-logical-delete.md) | STATUS とチェックによる論理削除 |
| [003](./003-task-dates.md) | 登録日と、状態を変えない終了予定日 |
| [004](./004-task-owner-isolation.md) | 本人の Task、404、持ち主の無い行は残す |

Language parity / 言語一致: [language-policy](../../rules/language-policy.md).
