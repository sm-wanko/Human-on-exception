# Human Prompts / 人間用プロンプト

Human-on-Exception has one optional bootstrap prompt plus five normal entry/resume prompts.

0. Greenfield bootstrap / Greenfield 初期化 — retire the executable example before starting a new product
1. Define Questions / Questions 作成
2. Apply Answers / Create Issue / Answers 反映・Issue 起票
3. Implement Issue / PR / Issue 実装・PR — [別コンテキストレビュー後にPR](./03-implement-reviewed.md) / [実装者レビューなしでPR](./03-implement-pr-first.md)
4. Resolve PR findings / PR 指摘対応
5. Merge / update target branch / マージ・対象ブランチ更新

The five normal workflow files are **not five approval gates**. Prompt 0 is setup, not an additional approval gate. Humans own purpose, scope, answers, and risk acceptance. Once an authorized stage has enough information, AI continues execution.

Prompts 1 and 2 are iterative. Applying an answer can expose a new semantic decision that did not exist before that answer. In that case, AI adds the follow-up Question and returns through the Answers step. Issue creation happens only after this loop converges and no unresolved human-authority implementation blocker remains.

通常フローの5本は **5回の人間承認を意味しない**。Prompt 0 は初期化であり、追加の承認ゲートではない。人間は目的・範囲・回答・リスク許容だけを持ち、許可済み工程は AI が継続する。

Prompt 1 と 2 は反復可能である。回答を反映したことで、それ以前には存在しなかった新しい semantic decision が顕在化することがある。その場合 AI は follow-up Question を追加し、再び Answers の工程へ戻る。このループが収束し、unresolved な human-authority implementation blocker が 0 件になった後にだけ Issue を起票する。

Execution contract / 実行契約: [ai-workflow.md](../docs/rules/ai-workflow.md)  
Independent review / 独立レビュー: [ai-review.md](../docs/rules/ai-review.md)  
Language parity / 言語一致: [language-policy.md](../docs/rules/language-policy.md)

Implementation procedure, SoT, and engineering rules are not duplicated into these prompts. Their authoritative sources are [AGENTS.md](../AGENTS.md) and `docs/rules/`.

実装手順・SoT・規約はプロンプトへ重複記載せず、[AGENTS.md](../AGENTS.md) と `docs/rules/` を正本とする。
