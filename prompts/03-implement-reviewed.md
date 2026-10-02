# 3A. Implement Issue / Separate Review / PR — Issue 実装 / 別コンテキストレビュー / PR

## English

Implement Issue #<number> through PR creation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §4. Confirm AC, allowed paths, and prohibitions. Own design, implementation, tests, static analysis, required completion / `make` commands, 4-point docs, and Pack updates.

Apply relevant concept / ADR / Policy. Work already determined by accepted criteria is AI execution. Return only unresolved semantic, actor-boundary, aggregation-unit, or risk decisions to the human.

For child Issues, use the Epic work branch as the base and state dependency order and PR base.

After implementation and verification, hand the change to a **different AI session / context** for review under `docs/rules/ai-review.md`. Do not substitute implementer self-review or a persona change for that review.

Record the reviewed base ref and head commit. That review is evidence only for the recorded head. If the head changes, repeat the separate-context review of the new head before creating the PR.

Resolve authorized valid findings, rerun verification, and repeat separate-context review as needed. Then create the PR.

Record Issue / Pack / Flow ID / evidence per AC / completion command results / reviewed base and head / independent-review result and any not-run reason in the PR.

## 日本語

Issue #<number> に沿って実装し、**別セッション / 別コンテキストの AI にレビューさせてから PR を作成**すること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・必要な完了/`make` コマンド・4点セット・Pack を更新すること。

関係する concept・ADR・Policy を適用し、合意済み基準で決まる個別作業は AI が実行すること。意味・主体・集約単位・未許容リスクを変える未決だけを人間へ戻すこと。

子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。

実装と検証が終わったら、実装者とは **別セッション / 別コンテキストの AI** に `docs/rules/ai-review.md` に従ってレビューさせること。実装者の自己レビューや人格変更で代替しないこと。

レビューした base と head commit を記録すること。そのレビューは記録した head に対する証拠である。head が変わった場合は、PR 作成前に新しい head を別コンテキストで再レビューすること。

許可済みの valid 指摘は修正し、再検証・必要な再レビューまで進めたうえで PR を作成すること。

PR には Issue / Pack / Flow ID / AC ごとの証拠 / 完了コマンド結果 / レビューした base と head / 独立レビュー結果 / 未実行理由を記録すること。
