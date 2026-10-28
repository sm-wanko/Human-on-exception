# 2. Apply Answers / Create Issue — Answers 反映 / Issue 起票

## English

<Questions path / answers by Q-ID / Scope / risk-acceptance decisions>

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §3. Apply the answers and preserve revision history without changing their original meaning. A Questions file with zero Q-IDs has no answers to apply. The separate-context look on that file must already be clear. Re-investigate the requested change against the recorded contract and create the Issue when no human-authority blocker remains.

Promote durable design decisions to ADR, repeatable criteria to Policy, and agreed purpose/core concepts to concept when needed. Avoid duplicating the same prose across sources.

After applying the answers, do not jump directly to Issue creation. Re-evaluate every investigation dimension affected by those answers against the combined target contract: original human facts, accepted answers, active ADR/Policy/concept, and still-valid AI assumptions. Explicitly look for consequences introduced by the answers themselves, such as new record kinds, actors, required fields, unit boundaries, lifecycle rules, mutable master/mapping/membership changes with possible retroactive effects, or concepts that no longer fit their previous meaning.

If this re-investigation finds a new decision that requires human authority, append a new stable Q-ID, explain the dependency on the accepted answer that exposed it, and return to the human. Preserve already accepted answers and revision history. Repeat this Apply Answers → Re-investigate → Follow-up Questions loop as many times as necessary.

Do not create an implementation Issue merely because the original Questions are all answered. Create the Issue only when the re-investigated target contract has zero unresolved human-authority implementation blockers.

Include Q-ID → AC-ID → verification mapping, Pack / Flow ID, allowed paths, prohibitions, and completion commands for that Issue's head under `docs/rules/ai-workflow.md` §4. A child Issue records the targeted proof. The Epic's integration PR, or a single Issue with no Epic, records full `make test` and full `make survey`.

AI owns splitting, Epic structure, and dependency order. Cross-link real Issues and Questions. Do not mark an unresolved design Issue Ready for implementation. If implementation was already authorized, continue the authorized workflow.

When Issue creation is complete, commit the contract documents produced up to that point. If an Epic was created, push only that Epic branch and cut each child Issue work branch from it. A single Issue with no Epic has no Epic branch and no child branch: push that Issue's work branch. That PR is the integration head.

## 日本語

<Questions のパス / Q-ID ごとの回答 / Scope / リスク許容判断>

`AGENTS.md` と `docs/rules/ai-workflow.md` §3 に従い、回答と改訂履歴を原意を変えずに反映すること。Q-ID が 0 件の Questions ファイルには、反映する回答がない。そのファイルの別コンテキスト照合は、すでに済んでいなければならない。依頼された変更を、記録された契約に対して再調査し、人間の権限の blocker が 0 件なら Issue を起票すること。

継続する設計判断は ADR、反復作業の基準は Policy、目的と概念は concept へ必要に応じて反映し、本文の重複を避けること。

回答を反映したら、そのまま Issue 起票へ進まないこと。回答の影響を受けた investigation dimension を、元の human facts、Accepted answers、active ADR / Policy / concept、まだ有効な AI assumptions を統合した target contract に対して再評価すること。特に、回答そのものによって新しく生まれた記録種別、actor、必須項目、unit boundary、lifecycle rule、後から変わる master / mapping / membership が既存記録へ遡及しうる箇所、従来の意味では整合しなくなった concept を明示的に探すこと。

この再調査で新たに人間の判断権限が必要な事項が見つかった場合は、新しい安定した Q-ID を追加し、どの Accepted answer によってその論点が顕在化したかを示して人間へ返すこと。既存の Accepted answer と改訂履歴は保持する。必要な回数だけ Apply Answers → 再調査 → follow-up Questions のループを繰り返すこと。

元の Questions がすべて回答済みという理由だけで実装 Issue を起票してはならない。再調査後の target contract に unresolved な human-authority implementation blocker が 0 件になった時だけ Issue を起票すること。

Q-ID → AC-ID → 検証方法の対応、Pack / Flow ID / 許可パス / 禁止 / `docs/rules/ai-workflow.md` §4 のその head の完了コマンドを含めること。子 Issue は targeted の証明を記す。Epic の統合 PR、または Epic が無い 1 本の Issue は、full `make test` と full `make survey` を記す。

分割・Epic・依存順は AI が具体化し、実在する Issue と Questions を相互リンクすること。未決の設計 Issue を実装 Ready にしないこと。既に実装まで許可されていれば続行すること。

Issue 起票が完了したら、そこまでの契約文書をコミットすること。Epic を作ったときは、その Epic ブランチだけを push し、子 Issue の作業ブランチはその Epic ブランチから切ること。Epic が無い 1 本の Issue には Epic ブランチも子ブランチもなく、その Issue の作業ブランチを push する。その PR が統合 head である。
