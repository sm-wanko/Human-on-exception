# 3. Implement Issue / PR — Issue 実装 / PR

## English

Implement Issue #<number> through PR creation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §4. Confirm AC, allowed paths, and prohibitions. Own design, implementation, tests, static analysis, self-review, 4-point docs, and Pack updates.

Apply relevant concept / ADR / Policy. Work already determined by accepted criteria is AI execution. Return only unresolved semantic, actor-boundary, aggregation-unit, or risk decisions to the human.

For child Issues, use the Epic work branch as the base and state dependency order and PR base.

Record Issue / Pack / Flow ID / evidence per AC / completion command results and any not-run reason in the PR.

Independent AI review follows `docs/rules/ai-review.md`. Implementer self-review is not separate-context review. Continue authorized finding resolution and re-verification.

## 日本語

Issue #<number> に沿って実装から PR 作成まで実施すること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・自己レビュー・4点セット・Pack を更新すること。

関係する concept・ADR・Policy を適用し、合意済み基準で決まる個別作業は AI が実行すること。意味・主体・集約単位・未許容リスクを変える未決だけを人間へ戻すこと。

子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。

PR には Issue / Pack / Flow ID / AC ごとの証拠 / 完了コマンド結果・未実行理由を記録すること。

独立 AI レビューは `docs/rules/ai-review.md` に従うこと。実装者の自己レビューを別人格レビューとして申告しないこと。許可済みの指摘対応・再検証まで進めること。
