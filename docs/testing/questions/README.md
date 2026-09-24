# questions（要件定義の経緯アーカイブ）

**用途**: 依頼者（人間）と AI の **要件定義・Q&A・決定の経緯**だけを置く。

| 置く | 置かない |
|------|----------|
| Issue 起票前の Question / Answered | DB スナップショット・監査ログ |
| 決定の経緯（なぜそうなったか） | いまの契約正本（→ flow / ui / validation / db / pack） |
| backlog 索引（questions 起点） | 実装手順・運用 runbook・コード地図 |

矛盾時: **実装 → test → flow**（[AGENTS.md](../../../AGENTS.md)）。本フォルダは経緯のみで、既存実装を docs だけで削除しない。

作成時は [Questions テンプレート](../../templates/questions.md) と [実行契約](../../rules/ai-workflow.md) §2–3 を適用する。

[Task CRUD](./task-crud.md) は既存実装に基づく教材用決定例で、実在する人間回答の証拠ではない。新規依頼でこれを回答として流用しない。
