# 3. Issue 実装 / PR

Issue #<number> に沿って実装から PR 作成まで実施すること。

AGENTS.md と docs/rules/ai-workflow.md §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・自己レビュー・4 点セット・Pack を更新すること。
関係するconcept・ADR・Policyを適用し、合意済み基準で決まる個別作業はAIが実行すること。意味や集約単位を変える未決だけを人間へ戻すこと。
子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。
PR テンプレートに Issue / Pack / Flow ID / AC ごとの証拠 / 完了 make の結果・未実行理由を記録すること。
独立 AI レビューは docs/rules/ai-review.md に従うこと。実装者の自己レビューを別人格レビューとして申告しないこと。許可済みの指摘対応・再検証まで進め、意思決定が必要な例外だけ戻すこと。
