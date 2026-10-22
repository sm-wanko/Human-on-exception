# 4. Resolve PR Review Findings / PR 指摘対応

## English

Handle findings for PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-review.md`.

When this PR stacks on another work branch, before classifying or fixing, check that base branch's latest pushed head. If this head does not contain it, merge it in. Completion of the base's independent review is not a precondition for the sync.

Classify every finding against that synced tree as `valid`, `false positive`, or `decision required`. Do not fix again a finding the sync already removed. Fix a remaining finding in the PR that introduced it, or in the PR that owns that responsibility.

For meaning-related findings, compare against concept / ADR / Policy. Do not remove agreed distinctions or invariants merely because the structure is complex.

For valid findings that belong to this PR, fix them and rerun the verification level of that PR under `docs/rules/ai-workflow.md` §4 on the head after any sync. A child PR reruns its targeted proof. An integration PR reruns full `make test` and full `make survey`. Reply with evidence and commit. For false positives, cite the agreed contract plus implementation/test evidence. In that same reply, resolve the review thread for each valid fix and each false positive. Do not ask the human to resolve it. Leave a `decision required` thread open. Resolving a thread does not complete independent review of the head.

Additional self-review by the implementation AI is optional and is not required. Do not perform it by default. It does not count as independent review, and it must not block the fix or the re-review request. After the fix and that verification are recorded, ask a separate context to classify the delta since the last valid evidence as reusable, partial, or full under `docs/rules/ai-review.md`, and request review of the uncovered scope. The implementation AI does not declare that reuse. For a child PR, one valid independent review is enough; requesting both Codex and Cursor Bugbot is recommended, and a service that did not run is recorded. The first review of an integration head inspects that whole head, and child coverage does not supply it. After that review is recorded, the same classification applies: a separate context confirms the invariant and the impact, unchanged scope carries, changed scope is re-reviewed, and an impact that cannot be bounded returns to a full re-review. Do not return the implementation to the human only because the fix is difficult.

Confirm coverage of the latest target head: unchanged scope already reviewed, scope rechecked for this head, and any uncovered remainder. An uncovered remainder or an unresolved valid or unclassified finding stays pending. Do not fill that gap with implementer self-review. Required checks are a separate gate. Do not return ordinary fixes to the human. Return only matters outside AI authority to Questions.

When the finding's code is in another repository that this PR's review service cannot open, the thread for that behavior is `prompts/04-local-review.md`. This prompt still handles findings that this PR's review can see.

## 日本語

PR #<number> の指摘に対応すること。

`AGENTS.md` と `docs/rules/ai-review.md` に従うこと。

この PR が別の作業ブランチに積まれているときは、分類と修正の前に、その依存元ブランチの最新の push 済み head を確認すること。この head がそれを含まなければ merge で同期すること。依存元の独立レビュー完了は、同期の条件にしないこと。

同期した木を基準に、全指摘を `valid` / `false positive` / `decision required` に分類すること。同期で解消済みの指摘は重ねて直さないこと。残る指摘は、それを導入した PR、またはその責務を持つ PR で修正すること。

意味に関わる指摘は concept・ADR・Policy と照合し、構造の複雑さだけで合意済みの区別や不変条件を削らないこと。

この PR に属する妥当な指摘は修正し、同期後の head に対して `docs/rules/ai-workflow.md` §4 のその PR の検証レベルをやり直すこと。子 PR は targeted の証明をやり直し、統合 PR は full `make test` と full `make survey` をやり直す。根拠と commit を返信すること。false positive は合意契約・実装・テストの根拠を示すこと。その同じ返信で、valid の修正と false positive のレビュースレッドを解決すること。人間に解決を頼まないこと。`decision required` のスレッドは開いたままにする。スレッドの解決は、対象 head の独立レビュー完了にはしない。

実装 AI による追加の自己レビューは任意（optional）であり、必須ではない。デフォルトでは実施しない。自己レビューは独立レビューにならず、修正や再レビュー依頼を止めてはならない。修正とその検証を記録したあと、別コンテキストに、直前の有効な証拠からの差分を `docs/rules/ai-review.md` の再利用可能・部分再レビュー・全面再レビューのどれかで判定させ、未確認の範囲のレビューを依頼すること。実装 AI はその再利用を宣言しない。子 PR は有効な独立レビュー証拠が 1 つあれば足り、Codex と Cursor Bugbot の両方は推奨とする。実施できなかったサービスは記録する。統合 head の初回レビューは、その head 全体を見る。子 PR の証拠では代替しない。その初回が記録されたあとは同じ判定に従う。別コンテキストが不変条件と影響範囲を確認し、不変範囲は証拠を引き継ぎ、変更範囲は独立して再レビューする。影響範囲を限定できなければ全面再レビューへ戻す。技術的な修正が難しいことだけでは、実装判断を人間へ戻さない。

最新 head のカバレッジを確認すること。以前のレビューが確認し、今も変わっていない範囲、この head で再確認した範囲、まだ見ていない範囲を分ける。未確認の範囲、または未解決の valid・未判定の指摘があれば pending とする。その穴を実装者の自己レビューで埋めないこと。必須チェックは別のゲートである。通常の修正を人間へ戻さず、AI に決定権がない事項だけ Questions へ戻すこと。

指摘のコードが、この PR のレビューサービスから開けない別リポジトリにあるときは、その挙動のスレッドを `prompts/04-local-review.md` に残す。このプロンプトは、この PR のレビューが見られる指摘を扱う。
