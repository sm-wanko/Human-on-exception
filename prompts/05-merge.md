# 5. Merge / Update Target Branch — マージ / 対象ブランチ更新

## English

Merge PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §5. Verify AC evidence for the latest head, required checks, review coverage under `docs/rules/ai-review.md`, and unresolved findings. Do not treat not-run, failed, pending, or unclassified work as success.

For a child PR, coverage is complete when unchanged scope already reviewed, scope rechecked for this head, and the uncovered remainder is empty. One valid independent review is enough. An unresolved valid or unclassified finding still blocks the merge. An integration head, including Epic into the branch that receives completed work, needs a first separate-context review of that whole head. Child coverage does not supply that first review. After it is recorded, unchanged scope carries only when a separate context confirms the invariant and the impact, changed scope is re-reviewed, and an unbounded impact returns to a full re-review. Required checks are a separate gate: review coverage does not make a failed or not-run check successful.

Verify required concept / ADR / Policy / 4-point doc synchronization and actual results of required verification commands. Aggregate Fail=0 or success from an older revision is not enough.

Confirm the PR base and repository branch workflow, merge, then confirm the actual merge result and update linked Issue / Epic state. Do not hard-code main/develop.

The PR body must contain `Closes #<issue>` for the Issue this merge completes. Naming the number in a table does not count. A child PR uses `Closes` only for its child Issue and must not close the Epic. An integration PR uses `Closes` for the Epic, or for the single Issue when there is no Epic. Do not merge when that keyword is missing. After the merge, confirm GitHub closed that Issue. If it is still open, the merge is not complete.

A child PR merged into an Epic work branch does not complete the Epic. Its evidence applies only to that child head. The integration head, the PR entering the branch that receives completed work, needs full `make test`, full `make survey`, and review coverage of that head under `docs/rules/ai-review.md`. The first review inspects that whole head, and child results do not supply it. Several Epics in one PR repeat those three on the combined head. A later Epic already verified on a head that contains the earlier Epic does not repeat that same head. One Issue with no Epic treats its PR into the receiving branch as the integration head.

This prompt is merge authorization for the target PR; do not request duplicate approval. Do not bypass protection settings. Return only decisions outside the authorized scope.

## 日本語

PR #<number> をマージすること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §5 に従い、最新 head の AC 証拠・必須チェック成功・`docs/rules/ai-review.md` のレビューカバレッジ・未解決指摘を確認すること。未実行・失敗・pending・未判定を成功にしないこと。

子 PR は、以前のレビューが確認し今も変わっていない範囲と、この head で再確認した範囲を合わせ、未確認の範囲が空ならカバレッジ完了とする。有効な独立レビュー証拠は 1 つで足りる。未解決の valid または未判定の指摘は、それでもマージを止める。Epic を含む、完了した作業を受け取るブランチへ入る統合 head は、初回にその head 全体の別コンテキストレビューを要する。子のカバレッジはその初回を代替しない。初回の記録があるあとは、別コンテキストが不変条件と影響範囲を確認した不変範囲だけ証拠を引き継ぎ、変更範囲は再レビューする。影響を限定できなければ全面再レビューへ戻す。必須チェックは別のゲートであり、レビューカバレッジは失敗や未実行のチェックを成功にしない。

必要な concept・ADR・Policy・4点セットの追従と、各必須検証の実行結果を照合すること。集約の Fail=0 や過去 revision の成功だけで完了にしないこと。

PR base とブランチ運用を確認してマージし、実際のマージ結果・関連 Issue / Epic の状態を更新すること。main / develop を決め打ちしないこと。

PR 本文には、このマージが完了させる Issue への `Closes #<issue>` が必要である。表の中に番号を書くだけでは数えない。子 PR の `Closes` は、その子 Issue だけであり、Epic を閉じてはならない。統合 PR の `Closes` は Epic、または Epic が無い 1 本の Issue である。そのキーワードが無いときはマージしない。マージのあと、GitHub がその Issue を閉じたことを確認する。開いたままなら、そのマージは完了ではない。

Epic 作業ブランチへの子 PR のマージは Epic を完了にしない。その証拠はその子 head に限る。完了した作業を受け取るブランチへ入る統合 head は、full `make test`、full `make survey`、`docs/rules/ai-review.md` のその head のレビューカバレッジを要する。初回レビューはその head 全体を見て、子の結果では代替しない。複数 Epic を 1 つの PR に入れるときは、合体後の head でこの 3 つをやり直す。先の Epic を含む head で後の Epic を検証済みなら、同じ head ではやり直さない。Epic が無い 1 本の Issue は、受け側ブランチへ入る PR を統合 head とする。

この指示が対象 PR のマージ許可なので再承認を要求しないこと。保護設定を迂回せず、許可範囲外の判断が必要な場合だけ根拠を示すこと。
