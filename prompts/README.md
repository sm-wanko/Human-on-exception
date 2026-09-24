# 人間用プロンプト

Human-on-Exception で人間が使うプロンプトはこの 5 本のみ。

1. Questions 作成
2. Answers 反映 / Issue 起票
3. Issue 実装 / PR
4. PR 指摘対応
5. マージ / 対象ブランチ更新

5 本は開始・再開用であり、5 回の人間承認を意味しない。人間は目的・範囲・回答・リスク許容だけを持ち、許可済み工程は AI が継続する。

実行契約は [ai-workflow.md](../docs/rules/ai-workflow.md)、独立レビューは [ai-review.md](../docs/rules/ai-review.md)。

実装手順・SoT・規約はプロンプトへ重複記載せず、[AGENTS.md](../AGENTS.md) と `docs/rules/` を正本とする。
