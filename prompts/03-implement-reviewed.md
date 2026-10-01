# 3A. Implement + Independent Review Before PR — 実装 → 独立レビュー → PR

## English

Implement Issue #<number> through PR creation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §4. Confirm AC, allowed paths, and prohibitions. Own design, implementation, tests, static analysis, required completion / `make` commands, 4-point docs, and Pack updates. Implementer self-review is not required.

Apply relevant concept / ADR / Policy. Work already determined by accepted criteria is AI execution. Return only unresolved semantic, actor-boundary, aggregation-unit, or risk decisions to the human.

For child Issues, use the Epic work branch as the base and state dependency order and PR base.

Before creating the PR, run an **independent reviewer in a separate session / context** against the candidate base/head diff and exact head commit, following `docs/rules/ai-review.md`. Do not simulate independence inside the implementer's context.

Classify every finding as `valid`, `false positive`, or `decision required`. Resolve authorized valid findings, rerun required verification, and have a separate-context reviewer recheck the latest head when the reviewed revision changes.

Create the PR only after the independent review covers the exact candidate head and no valid or unclassified finding remains. Record Issue / Pack / Flow ID / evidence per AC / command results / reviewed base and head revisions / independent-review evidence and any not-run reason in the PR.

## 日本語

Issue #<number> に沿って、実装から **PR作成前の別コンテキストレビュー**、PR作成まで実施すること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・必要な完了/`make` コマンド・4点セット・Pack を更新すること。**実装者の自己レビューは必須ではない。**

関係する concept・ADR・Policy を適用し、合意済み基準で決まる個別作業は AI が実行すること。意味・主体・集約単位・未許容リスクを変える未決だけを人間へ戻すこと。

子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。

PRを作る前に、実装者とは **別セッション / 別コンテキスト** のレビュアーを起動し、候補 base/head の差分と正確な head commit を `docs/rules/ai-review.md` に従ってレビューさせること。実装者自身のコンテキスト内で人格だけを変えて独立レビューを模倣しないこと。

全指摘を `valid` / `false positive` / `decision required` に分類すること。許可済みの valid 指摘は修正し、必要な検証を再実行すること。レビュー後に head が変わった場合は、最新 head を別コンテキストで再レビューすること。

**正確な候補 head が独立レビュー済みで、valid または未分類の指摘が残っていない状態でPRを作成すること。** PR には Issue / Pack / Flow ID / AC ごとの証拠 / コマンド結果 / レビュー対象 base・head revision / 独立レビュー証拠 / 未実行理由を記録すること。
