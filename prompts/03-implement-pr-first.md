# 3B. Implement Issue / PR Without Implementer Review — Issue 実装 / レビューなし PR

## English

Implement Issue #<number> through PR creation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §4. Confirm AC, allowed paths, and prohibitions. Own design, implementation, tests, static analysis, required completion / `make` commands, 4-point docs, and Pack updates.

Apply relevant concept / ADR / Policy. Work already determined by accepted criteria is AI execution. Return only unresolved semantic, actor-boundary, aggregation-unit, or risk decisions to the human.

For child Issues, use the Epic work branch as the base and state dependency order and PR base.

**Do not perform or require implementer self-review.** After implementation, tests, static analysis, required completion / `make` commands, and docs/Pack updates are complete, create the PR.

Record Issue / Pack / Flow ID / evidence per AC / completion command results and any not-run reason in the PR. Mark independent AI review as `pending` when it has not run yet.

This variant is intended for cases where review will be performed on the created PR by Codex, Cursor Bugbot, GitHub Copilot, Claude, or another separate-context reviewer.

## 日本語

Issue #<number> に沿って実装から PR 作成まで実施すること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §4 に従い、AC・許可パス・禁止を確認し、設計・実装・テスト・静的解析・必要な完了/`make` コマンド・4点セット・Pack を更新すること。

関係する concept・ADR・Policy を適用し、合意済み基準で決まる個別作業は AI が実行すること。意味・主体・集約単位・未許容リスクを変える未決だけを人間へ戻すこと。

子 Issue は Epic 作業ブランチを基準にし、依存順と PR base を明示すること。

**実装者による自己レビューは実施・必須化しないこと。** 実装、テスト、静的解析、必要な完了/`make` コマンド、4点セット・Pack 更新が完了したら PR を作成すること。

PR には Issue / Pack / Flow ID / AC ごとの証拠 / 完了コマンド結果・未実行理由を記録すること。独立 AI レビューがまだ実施されていない場合は `pending` と記録すること。

このプロンプトは、作成された PR を Codex / Cursor Bugbot / GitHub Copilot / Claude 等の別コンテキストにレビューさせる場合に使う。
