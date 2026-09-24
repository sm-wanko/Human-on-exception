# 使用言語

- 日本語を使用する。

# Rules

- 手順・完了・SoT: [`AGENTS.md`](../AGENTS.md)
- 会員向け mutation の監査（正本）: [`docs/rules/audit-ui-persistence.md`](../docs/rules/audit-ui-persistence.md)

# Backend: 画面経路の永続化と監査（レビュー必須）

認証済み UI / API から触る mutation を変更・追加する PR では、監査 rule の MUST を指摘対象とする。SIT は `docs/rules/system-test-strategy.md` §4.1。

# 独立レビュー

[ai-review.md](../docs/rules/ai-review.md) を適用する。実装者の自己レビューを独立レビューで代替済みと見なさない。

# Review Priority

- 実装提案よりリスク検知を優先
- 潜在バグを優先
- 推測で褒めない
- 問題がない場合は簡潔に述べる
- AGENTS.md のタスク遂行手順には従わない（レビュー観点を優先）
- 修正実装ではなくレビュー観点を優先
- 変更意図が不明な場合は推測しない
- 指摘には「影響範囲」と「再現条件」を含める
- コードスタイルのみより、動作リスク・保守性・仕様逸脱を優先
