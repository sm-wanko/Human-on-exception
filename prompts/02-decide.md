# 2. Apply Answers / Create Issue — Answers 反映 / Issue 起票

## English

<Questions path / answers by Q-ID / Scope / risk-acceptance decisions>

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §3. Apply the answers and preserve revision history without changing their original meaning.

Promote durable design decisions to ADR, repeatable criteria to Policy, and agreed purpose/core concepts to concept when needed. Avoid duplicating the same prose across sources.

Ask only about additional items that still require human decision authority. If implementation blockers are zero, create the Issue.

Include Q-ID → AC-ID → verification mapping, Pack / Flow ID, allowed paths, prohibitions, and completion `make` commands.

AI owns splitting, Epic structure, and dependency order. Cross-link real Issues and Questions. Do not mark an unresolved design Issue Ready for implementation. If implementation was already authorized, continue the authorized workflow.

## 日本語

<Questions のパス / Q-ID ごとの回答 / Scope / リスク許容判断>

`AGENTS.md` と `docs/rules/ai-workflow.md` §3 に従い、回答と改訂履歴を原意を変えずに反映すること。

継続する設計判断は ADR、反復作業の基準は Policy、目的と概念は concept へ必要に応じて反映し、本文の重複を避けること。

追加で人間判断が必要な項目だけ相談し、実装 blocker がなければ Issue を起票すること。

Q-ID → AC-ID → 検証方法の対応、Pack / Flow ID / 許可パス / 禁止 / 完了 `make` を含めること。

分割・Epic・依存順は AI が具体化し、実在する Issue と Questions を相互リンクすること。未決の設計 Issue を実装 Ready にしないこと。既に実装まで許可されていれば続行すること。
