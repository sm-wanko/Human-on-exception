# 3. Implement Issue / PR — Issue 実装 / PR

Choose one execution mode for Issue #<number>. Both modes require implementation, tests, static analysis, required `make` commands, docs/Pack alignment, and PR evidence. Implementer self-review is not required.

- [3A. Implement + independent review before PR](./03-implement-reviewed.md)
- [3B. Implement + PR first](./03-implement-pr-first.md)

Use **3A** when the execution environment can run a reviewer in a genuinely separate session / context before PR creation. Use **3B** when the implementation agent cannot create a separate reviewer context—for example, when a GitHub-hosted coding agent will open the PR and an external Codex / Bugbot / Copilot / Claude review runs on the PR afterward.

Do not simulate independence by changing persona or reviewing in the implementer's own context. Independent review follows `docs/rules/ai-review.md`.

## 日本語

Issue #<number> は、実行環境に応じて次のどちらかで進めること。どちらも、実装・テスト・静的解析・必要な `make` コマンド・4点セット/Pack整合・PRへの証拠記録は必須とする。**実装者の自己レビューは必須ではない。**

- [3A. 実装 → 別コンテキストレビュー → PR](./03-implement-reviewed.md)
- [3B. 実装 → PR先行](./03-implement-pr-first.md)

PR作成前に、実装者とは**別セッション / 別コンテキスト**のレビュー担当を実行できる環境では **3A** を使う。GitHub上の coding agent のように実装担当自身が別コンテキストを生成できず、PR作成後に Codex / Bugbot / Copilot / Claude 等へレビューさせる環境では **3B** を使う。

口調や役割名を変えただけの自己レビューを独立レビューとして扱わないこと。独立レビューは `docs/rules/ai-review.md` に従うこと。
