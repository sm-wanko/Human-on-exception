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
| 子 head は Issue の AC を局所証明する | ai-workflow §4 / AGENTS completion | targeted test、lint / static、route・matrix・4点セット構造に触れたときの survey、その子 PR の独立レビュー。永続化や境界をまたぐ変更は、その Flow の system test を含む。full suite は子の証明にしない |
| 統合 head が完了証明である | ai-workflow §4–§5 | full `make test`、full `make survey`、その head の別コンテキストレビュー。子の結果は流用しない。ブランチ名は決め打ちしない |
| Pack drift audit は変更ごとの gate ではない | ai-workflow §7 / `prompts/06-drift-audit.md` | 1 Pack の蓄積変更を監査し、その場では修復しない。01–05 の完了に Prompt 6 を要求しない |
| drift は現状事実と目標契約を区別する | ai-workflow §6–§7 | docs の遅れを、tests と合意契約が実装を支持しているときに契約違反へ上げない。合意済み target に実装が遅れているのを、現状 SoT の順位を理由に許容しない |
| 既知リスク領域は適用可能な根拠を調べる | ai-workflow §2 Evidence / safety、ai-review | 変更が既知の横断リスク領域に明確に入るとき、適用される repository rule、accepted Policy/ADR、platform constraint、verification method を確認する。適用されない種類を必須にしない |
| 信頼できる基準がなければ欠落を記録する | ai-workflow §2、ai-review | Risks / Unknowns / Assumptions に記録する。チェックリストを訪問しただけでは安全・完了にしない。未知リスクの発見は保証しない |

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
| 子 PR の base が Epic 作業ブランチ | その head で AC の targeted test、lint、構造に触れたときの survey、子 PR の独立レビューを記録する | full `make test` の成功を子の完了にする / 子の成功で Epic を閉じる |
| Epic、複数 Epic、または Epic の無い 1 Issue が受け側ブランチへ入る | その統合 head で full `make test`、full `make survey`、別コンテキストレビューを行う。複数 Epic を一度に入れるときは合体後 head でやり直す。先の Epic を含む head で検証済みなら同じ head ではやり直さない | 子のレビューや targeted test を統合 head の証明にする / 別 head の成功を流用する |
| 妥当な変更が積み重なり Pack の意味がずれる | Prompt 6 が repo から SoT を再構成し、severity と routing を分けて分類する。意味の未決だけを Question にする | 監査中に修復する / P1 を人間のコードレビュー gate にする / 毎回の変更完了に Prompt 6 を要求する |
| docs が実装より古いが tests と合意契約は実装と一致する | 現状事実の docs drift として routing し、実装を削除しない | docs を単独の正本として実装を削除する |
| 変更が既知の横断リスク領域に明確に入る | 適用される repository rule、accepted Policy/ADR、platform constraint、verification method を調べる | 一覧を訪れただけで調査済みにする / platform constraint だけが根拠なのにそれを見ない / 存在しない decision を必須にする |
| 既知リスクに信頼できる基準がない | その欠落を Risks / Unknowns / Assumptions に記録する | 基準がないことを安全またはレビュー通過とみなす |

## Example scope

`EXAMPLE_TASK_CRUD` は workflow と検証面を説明するための教材。

- list/detail UI + CRUD API
- auth / per-user ownership / member audit / mutation UI は main の教材スコープ外
- Questions 内の teaching Answers は実在ユーザーの承認履歴ではない
- 教材の目的は「完成したSaaS」ではなく、契約→実装→検証の追跡可能性を示すこと

教材の 1 本を受け側ブランチへ入れるときは、統合 head として `make lint` を含む full `make test` と `make survey` をその revision で記録する。子 head の基準は ai-workflow §4 である。
