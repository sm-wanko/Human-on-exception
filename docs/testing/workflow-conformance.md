# Workflow Conformance

Human-on-Exception のルールが、単なる文章ではなく一貫した開発契約として成立しているかを確認するための受け入れ観点。

この文書は特定の外部プロダクトやリポジトリの履歴を根拠にしない。現在の Human-on-Exception リポジトリ内の rules / prompts / templates / example を対象に確認する。

## Contract map

| Property | Source | What to verify |
|---|---|---|
| 人間は Intent / Scope / Answers / Risk acceptance を持つ | `docs/rules/ai-workflow.md` | 通常の実装・修正・レビューを人間 gate にしない |
| AI は既存事実を調査してから Questions を作る | ai-workflow §2 / Questions template | repoから取得できる事実を人間に聞かない |
| 人間判断は Q-ID → AC-ID → test/docs へ落ちる | ai-workflow §3 / Issue templates | 決定と検証証拠が追跡できる |
| 現状SoTと変更後契約を区別する | AGENTS / ai-workflow §6 | 古い実装を理由に合意済み変更を拒否しない |
| docs / tests / implementation を同一変更系列でそろえる | docs-follow / ai-review | diffにない関連docsの更新漏れも検出する |
| 独立AIレビューを実装者の自己レビューと区別する | ai-review / tool entrypoints | 別コンテキストでAC・SoT・diff・testsを再確認する |
| valid / false positive / decision required を分類する | ai-review | 普通の修正を人間へ転送しない |
| pending / skipped / not-run を成功扱いしない | ai-workflow §4–5 | 実行証拠と対象revisionを確認する |
| 人間コードレビューを必須gateにしない | ai-workflow §5 | 必須チェックと独立AIレビューで完了判断する |

## Acceptance scenarios

| Situation | Expected behavior | Failure |
|---|---|---|
| 「この機能を追加したい」 | AIが現状契約を調査し、意味・範囲・リスクの未決事項だけQuestions化 | いきなり実装する / repoで分かることを人間に質問 |
| 回答が既存仕様を変更する | Answers / Issue AC を target contract とし、実装・tests・docsを更新 | 現状実装がSoT上位だからという理由で変更を拒否 |
| 変更されたAPIに関連docsがdiffにない | reviewerが影響範囲から未更新ファイルを発見して指摘 | PR diffにないため確認対象外にする |
| review finding が出る | AIが valid / false positive / decision required に分類し、validは修正 | 全件を人間へ転送 / 全件を無条件採用 |
| tests が失敗する | AIが原因を調査・修正し、再検証 | 「例外」として人間へ実装修正を戻す |
| 新しい意味・権限境界が必要 | 証拠、選択肢、推奨をQuestionsで人間へ返す | AIが慣例だけで意味を確定する |
| aggregate command が成功したが子工程がskip | 未完了として扱い、対象revisionと各工程を確認 | Fail=0だけでDoneにする |
| docsとimplementationが矛盾 | current-state調査では implementation → system test → flow の順で事実確認 | docsだけを根拠に既存実装を削除 |
| agreed change後のdocsが古い | target contractに合わせてコード・tests・4-point docsを同期 | current-state SoTを理由に古いdocsを放置 |

## Example scope

`EXAMPLE_TASK_CRUD` は workflow と検証面を説明するための教材。

- list/detail UI + CRUD API
- auth / per-user ownership / member audit / mutation UI は main の教材スコープ外
- Questions 内の teaching Answers は実在ユーザーの承認履歴ではない
- 教材の目的は「完成したSaaS」ではなく、契約→実装→検証の追跡可能性を示すこと

実行確認は `make lint` → `make test` → `make survey` を基準とし、結果は対象revisionごとに記録する。
