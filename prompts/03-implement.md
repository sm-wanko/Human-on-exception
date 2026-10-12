# 3. Implement Issue / PR — Issue 実装 / PR

Choose the prompt that matches how review will be performed.

- [3A. Implement → separate-context review → PR](./03-implement-reviewed.md)
- [3B. Implement → PR without implementer review](./03-implement-pr-first.md)

Both variants keep the same implementation requirements: Issue AC, allowed paths/prohibitions, tests, static analysis, required completion / `make` commands, 4-point docs, Pack updates, and PR evidence.

Recommended: keep the implementation AI and the review AI in separate contexts, and do not have the implementation AI self-review before creating the PR. In either variant, after the PR is created, comment `@codex review` on that PR.

## 日本語

レビューの実行方法に合わせて、次のどちらかを使うこと。

- [3A. 実装 → 別コンテキストレビュー → PR](./03-implement-reviewed.md)
- [3B. 実装 → 実装者レビューなし → PR](./03-implement-pr-first.md)

どちらも、Issue の AC・許可パス・禁止、テスト、静的解析、必要な完了/`make` コマンド、4点セット、Pack 更新、PR への証拠記録は維持すること。

推奨は、実装 AI とレビュー AI を別コンテキストに分け、PR 作成前に実装 AI が自己レビューしないこと。いずれの場合も、PR 作成後にその PR へ `@codex review` とコメントすること。
