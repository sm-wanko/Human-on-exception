# 4. Resolve PR Review Findings / PR 指摘対応

## English

Handle findings for PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-review.md`. Classify every finding as `valid`, `false positive`, or `decision required`.

For meaning-related findings, compare against concept / ADR / Policy. Do not remove agreed distinctions or invariants merely because the structure is complex.

For valid findings, fix them and rerun the verification level of that PR under `docs/rules/ai-workflow.md` §4. A child PR reruns its targeted proof. An integration PR reruns full `make test`, full `make survey`, and review of the new head. Reply with evidence and commit. For false positives, cite the agreed contract plus implementation/test evidence.

Check independent AI re-review of the latest target head and required checks. A review of only the incremental diff since the previous head does not complete that check. If review of the target head did not run, keep it pending. Do not return ordinary fixes to the human. Return only matters outside AI authority to Questions.

When the finding's code is in another repository that this PR's review service cannot open, the thread for that behavior is `prompts/04-local-review.md`. This prompt still handles findings that this PR's review can see.

## 日本語

PR #<number> の指摘に対応すること。

`AGENTS.md` と `docs/rules/ai-review.md` に従い、全指摘を `valid` / `false positive` / `decision required` に分類すること。

意味に関わる指摘は concept・ADR・Policy と照合し、構造の複雑さだけで合意済みの区別や不変条件を削らないこと。

妥当なら修正し、`docs/rules/ai-workflow.md` §4 のその PR の検証レベルをやり直す。子 PR は targeted の証明をやり直し、統合 PR は full `make test`、full `make survey`、新しい head のレビューをやり直す。根拠と commit を返信して解決すること。false positive は合意契約・実装・テストの根拠を示すこと。

最新の対象 head に対する独立 AI 再レビューと必須チェックを確認すること。前回 head 以降の追加差分だけの確認では、その再レビューを完了にしない。対象 head のレビューが未実施なら pending とすること。通常の修正を人間へ戻さず、AI に決定権がない事項だけ Questions へ戻すこと。

指摘のコードが、この PR のレビューサービスから開けない別リポジトリにあるときは、その挙動のスレッドを `prompts/04-local-review.md` に残す。このプロンプトは、この PR のレビューが見られる指摘を扱う。
