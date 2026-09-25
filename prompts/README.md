# Human Prompts / 人間用プロンプト

Human-on-Exception exposes only these five human entry/resume prompts.

1. Define Questions / Questions 作成
2. Apply Answers / Create Issue / Answers 反映・Issue 起票
3. Implement Issue / PR / Issue 実装・PR
4. Resolve PR findings / PR 指摘対応
5. Merge / update target branch / マージ・対象ブランチ更新

These five files are **not five approval gates**. Humans own purpose, scope, answers, and risk acceptance. Once an authorized stage has enough information, AI continues execution.

この5本は **5回の人間承認を意味しない**。人間は目的・範囲・回答・リスク許容だけを持ち、許可済み工程は AI が継続する。

Execution contract / 実行契約: [ai-workflow.md](../docs/rules/ai-workflow.md)  
Independent review / 独立レビュー: [ai-review.md](../docs/rules/ai-review.md)  
Language parity / 言語一致: [language-policy.md](../docs/rules/language-policy.md)

Implementation procedure, SoT, and engineering rules are not duplicated into these prompts. Their authoritative sources are [AGENTS.md](../AGENTS.md) and `docs/rules/`.

実装手順・SoT・規約はプロンプトへ重複記載せず、[AGENTS.md](../AGENTS.md) と `docs/rules/` を正本とする。
