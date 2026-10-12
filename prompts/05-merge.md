# 5. Merge / Update Target Branch — マージ / 対象ブランチ更新

## English

Merge PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §5. Verify AC evidence for the latest head, required checks, independent AI review, and unresolved findings. Do not treat not-run, failed, pending, or unclassified work as success.

Verify required concept / ADR / Policy / 4-point doc synchronization and actual results of required verification commands. Aggregate Fail=0 or success from an older revision is not enough.

Confirm the PR base and repository branch workflow, merge, then confirm the actual merge result and update linked Issue / Epic state. Do not hard-code main/develop.

When this PR merges a child change into an Epic work branch, that merge does not complete the Epic. The child head's command results and review are evidence only for that child head. Integration verification still runs on the later integrated head. This does not reduce the verification the child head must already have recorded.

This prompt is merge authorization for the target PR; do not request duplicate approval. Do not bypass protection settings. Return only decisions outside the authorized scope.

## 日本語

PR #<number> をマージすること。

`AGENTS.md` と `docs/rules/ai-workflow.md` §5 に従い、最新 head の AC 証拠・必須チェック成功・独立 AI レビュー・未解決指摘を確認すること。未実行・失敗・pending・未判定を成功にしないこと。

必要な concept・ADR・Policy・4点セットの追従と、各必須検証の実行結果を照合すること。集約の Fail=0 や過去 revision の成功だけで完了にしないこと。

PR base とブランチ運用を確認してマージし、実際のマージ結果・関連 Issue / Epic の状態を更新すること。main / develop を決め打ちしないこと。

この PR が子変更を Epic 作業ブランチへマージする場合、そのマージは Epic を完了にしない。子 head のコマンド結果とレビューは、その子 head の証拠である。integration verification は、その後の統合 head で行う。子 head が記録すべき検証を、この区別で減らさないこと。

この指示が対象 PR のマージ許可なので再承認を要求しないこと。保護設定を迂回せず、許可範囲外の判断が必要な場合だけ根拠を示すこと。
