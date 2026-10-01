# 3B. Implement + PR First — 実装 → PR先行

## English

Implement Issue #<number> through PR creation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §4. Confirm AC, allowed paths, and prohibitions. Own design, implementation, tests, static analysis, required completion / `make` commands, 4-point docs, and Pack updates. **Do not require implementer self-review before opening the PR.**

Apply relevant concept / ADR / Policy. Work already determined by accepted criteria is AI execution. Return only unresolved semantic, actor-boundary, aggregation-unit, or risk decisions to the human.

For child Issues, use the Epic work branch as the base and state dependency order and PR base.

After implementation and required verification, create the PR without inventing a same-context "review" step. Record Issue / Pack / Flow ID / evidence per AC / command results and any not-run reason in the PR. If independent review has not run yet, record it explicitly as `pending`.

A separate-context reviewer such as Codex / Cursor Bugbot / GitHub Copilot / Claude then reviews the PR under `docs/rules/ai-review.md`. Continue authorized finding classification, fixes, re-verification, and re-review until completion criteria are met.

## 日本語

Issue #<number> に沿って実装から PR 作成まで実施すること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・必要な完了/`make` コマンド・4点セット・Pack を更新すること。**PR作成前の実装者自己レビューを必須にしないこと。**

関係する concept・ADR・Policy を適用し、合意済み基準で決まる個別作業は AI が実行すること。意味・主体・集約単位・未許容リスクを変える未決だけを人間へ戻すこと。

子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。

実装と必要な検証が完了したら、同一コンテキスト内の擬似レビュー工程を挟まず PR を作成すること。PR には Issue / Pack / Flow ID / AC ごとの証拠 / コマンド結果 / 未実行理由を記録すること。独立レビューがまだ走っていない場合は、**`pending` と明記**すること。

その後、Codex / Cursor Bugbot / GitHub Copilot / Claude 等の **別コンテキスト** のレビュアーが `docs/rules/ai-review.md` に従ってPRをレビューする。完了条件を満たすまで、許可済みの指摘分類・修正・再検証・再レビューを継続すること。
