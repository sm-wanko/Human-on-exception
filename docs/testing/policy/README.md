# Policy — Repeatable Decision Criteria / 反復作業の判断基準

## English

Policy is the operational source of truth that lets AI apply an already agreed decision repeatedly without returning every instance to the human.

ADR stores **why a choice was adopted**. Policy stores **the concrete criteria used to apply that choice to individual work items**. Apply [domain-decisions](../../rules/domain-decisions.md).

The current sample has no standalone domain-operation Policy. Create one only when repeatable work actually appears.

| Field | Meaning |
|---|---|
| Status / scope | Active / Superseded, in/out scope, source ADR and human-answer reference |
| Meaning / examples | terminology, accepted examples, rejected counterexamples, out-of-contract input |
| AI execution scope | decided fixes, item-by-item inspection, verification, allowed targets |
| Return-to-human condition | new concept, semantic ambiguity, unaccepted risk, stop/resume boundary |
| Edits / evidence | target IDs, reasons, prohibited bulk operations, verification command, evidence location |
| Revision | answer source, replacement, affected AC/tests, review trigger |

AI proceeds when the criterion is explicit and holds only ambiguous items. "Individual inspection" does not mean every item requires human review. Do not silently add a new criterion to an existing Policy; settle the decision first.

Questions retains unresolved items and answer history. Batch progress/offset belongs in an Issue or operations material, not in Policy or Questions.

## 日本語

同じ判断を毎回人間へ戻さず、AI が合意済みの基準を適用するための運用正本。ADR は採用理由、Policy は個々の作業に適用する具体的な基準を持つ。[意味と判断の継承](../../rules/domain-decisions.md) を適用する。

現サンプルには独立したドメイン運用 Policy はない。反復作業が必要になったときだけ、AI が下記の構成で作成する。

| 項目 | 内容 |
|---|---|
| Status / 適用範囲 | Active / Superseded、対象と非対象、根拠 ADR・人間の回答参照 |
| 意味と例 | 用語、許容例、拒否する反例、契約外入力 |
| AI の実行範囲 | 判断済みの修正・個別精査・検証、変更を許可する対象 |
| 人間へ戻す条件 | 新概念・意味の曖昧さ・未許容リスク、停止範囲と再開条件 |
| 編集と証拠 | 対象 ID・理由・禁止する一括処理・確認コマンド・結果の置き場 |
| 改訂 | 回答の出所、置換先、関連する AC・テストへの影響、見直し条件 |

AI は基準が明確な作業を進め、曖昧な項目だけを保留する。「個別精査」は人間による全件レビューを意味しない。新基準を既存 Policy へ黙って混ぜず、必要な意思決定を先に確定する。

Questions には未決と回答経緯を残す。進捗・バッチ番号は Issue または専用の運用資料へ置き、確定した基準を複数文書に再掲しない。

Language selection / translation / 言語選択・翻訳: [language-policy](../../rules/language-policy.md).
