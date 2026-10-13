# 3. Implement Issue / PR — Issue 実装 / PR

Choose the prompt that matches how review will be performed.

- [3A. Implement → separate-context review → PR](./03-implement-reviewed.md)
- [3B. Implement → PR without implementer review](./03-implement-pr-first.md)

Both variants keep the same implementation requirements: Issue AC, allowed paths/prohibitions, tests, static analysis, the verification level in `docs/rules/ai-workflow.md` §4, 4-point docs, Pack updates, and PR evidence.

A child PR, whose base is an Epic work branch, records targeted tests for that Issue's AC, lint / static analysis, survey when a route, flow test matrix, or 4-point structure changes, and independent review of that child head. A change that persists data or crosses a boundary includes that Flow's system tests. The full suite is the integration head's proof, not the child's. A single Issue with no Epic uses the PR into the receiving branch as the integration head: full `make test`, full `make survey`, and a separate-context review of that head. Do not hard-code `develop` or `main`.

Recommended: keep the implementation AI and the review AI in separate contexts, and do not have the implementation AI self-review before creating the PR. In either variant, after the PR is created, comment `@codex review` on that PR.

## 日本語

レビューの実行方法に合わせて、次のどちらかを使うこと。

- [3A. 実装 → 別コンテキストレビュー → PR](./03-implement-reviewed.md)
- [3B. 実装 → 実装者レビューなし → PR](./03-implement-pr-first.md)

どちらも、Issue の AC・許可パス・禁止、テスト、静的解析、`docs/rules/ai-workflow.md` §4 の検証レベル、4点セット、Pack 更新、PR への証拠記録は維持すること。

Epic 作業ブランチが base の子 PR は、その Issue の AC に対する targeted test、lint / 静的解析、route・flow の test matrix・4点セット構造に触れたときの survey、その子 head の独立レビューを記録する。永続化や境界をまたぐ変更は、その Flow の system test を targeted test に含める。full suite は子の証明ではなく、統合 head の証明である。Epic が無い 1 本の Issue は、受け側ブランチへ入る PR を統合 head とし、full `make test`、full `make survey`、その head の別コンテキストレビューを行う。`develop` や `main` を決め打ちしない。

推奨は、実装 AI とレビュー AI を別コンテキストに分け、PR 作成前に実装 AI が自己レビューしないこと。いずれの場合も、PR 作成後にその PR へ `@codex review` とコメントすること。
