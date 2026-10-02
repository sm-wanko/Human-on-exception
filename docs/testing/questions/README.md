# Questions — Decision-history archive / 要件定義の経緯アーカイブ

## English

**Purpose**: store only the **requirements Q&A and decision history** between the human requester and AI.

| Store here | Do not store here |
|---|---|
| Questions / Answers before Issue creation | DB snapshots / audit logs |
| Why a decision was made | current contract SoT → flow / ui / validation / db / pack |
| backlog index originating from Questions | implementation procedure / runbook / code map |

When current-state sources conflict: **implementation → test → flow** according to [AGENTS.md](../../../AGENTS.md). This folder is history only. Do not delete implementation because a historical Question says something different.

Use the [Questions template](../../templates/questions.md) and [AI execution contract](../../rules/ai-workflow.md) §2–3.

[Task CRUD](./task-crud.md) is a teaching example based on the existing sample. It is not evidence of an actual human answer and must not be reused as an accepted answer for a new request.

## 日本語

**用途**: 依頼者（人間）と AI の **要件定義・Q&A・決定の経緯**だけを置く。

| 置く | 置かない |
|---|---|
| Issue 起票前の Question / Answered | DB スナップショット・監査ログ |
| 決定の経緯（なぜそうなったか） | いまの契約正本（→ flow / ui / validation / db / pack） |
| backlog 索引（questions 起点） | 実装手順・運用 runbook・コード地図 |

矛盾時: **実装 → test → flow**（[AGENTS.md](../../../AGENTS.md)）。本フォルダは経緯のみで、既存実装を docs だけで削除しない。

作成時は [Questions テンプレート](../../templates/questions.md) と [実行契約](../../rules/ai-workflow.md) §2–3 を適用する。

[Task CRUD](./task-crud.md) は既存実装に基づく教材用決定例で、実在する人間回答の証拠ではない。新規依頼でこれを回答として流用しない。

Language selection / translation / 言語選択・翻訳: [language-policy](../../rules/language-policy.md).
