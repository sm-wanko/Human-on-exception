# 5. Merge / Update Target Branch — マージ / 対象ブランチ更新

## English

Merge PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §5. Verify AC evidence for the latest head, required checks, independent AI review, and unresolved findings. Do not treat not-run, failed, pending, or unclassified work as success.

Verify required concept / ADR / Policy / 4-point doc synchronization and actual results of required verification commands. Aggregate Fail=0 or success from an older revision is not enough.

Confirm the PR base and repository branch workflow, merge, then confirm the actual merge result and update linked Issue / Epic state. Do not hard-code main/develop.

A child PR merged into an Epic work branch does not complete the Epic. Its evidence applies only to that child head. The integration head, the PR entering the branch that receives completed work, needs full `make test`, full `make survey`, and a separate-context review of that head. Child results do not supply that proof. Several Epics in one PR repeat those three on the combined head. A later Epic already verified on a head that contains the earlier Epic does not repeat that same head. One Issue with no Epic treats its PR into the receiving branch as the integration head.

This prompt is merge authorization for the target PR; do not request duplicate approval. Do not bypass protection settings. Return only decisions outside the authorized scope.

## 日本語

PR #<number> をマージすること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §5 に従い、最新 head の AC 証拠・必須チェック成功・独立 AI レビュー・未解決指摘を確認すること。未実行・失敗・pending・未判定を成功にしないこと。

必要な concept・ADR・Policy・4点セットの追従と、各必須検証の実行結果を照合すること。集約の Fail=0 や過去 revision の成功だけで完了にしないこと。

PR base とブランチ運用を確認してマージし、実際のマージ結果・関連 Issue / Epic の状態を更新すること。main / develop を決め打ちしないこと。

Epic 作業ブランチへの子 PR のマージは Epic を完了にしない。その証拠はその子 head に限る。完了した作業を受け取るブランチへ入る統合 head は、full `make test`、full `make survey`、その head の別コンテキストレビューを要する。子の結果はその証明にならない。複数 Epic を 1 つの PR に入れるときは、合体後の head でこの 3 つをやり直す。先の Epic を含む head で後の Epic を検証済みなら、同じ head ではやり直さない。Epic が無い 1 本の Issue は、受け側ブランチへ入る PR を統合 head とする。

この指示が対象 PR のマージ許可なので再承認を要求しないこと。保護設定を迂回せず、許可範囲外の判断が必要な場合だけ根拠を示すこと。
