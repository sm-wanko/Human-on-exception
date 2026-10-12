# Verification granularity — Questions

> Bilingual human-facing record. English and Japanese preserve the same decision-relevant meaning. See [language-policy](../../rules/language-policy.md).

**Status / 状態**: Awaiting answers / 回答待ち  
**Pack / Flow ID**: workflow contract / 実行契約（特定の製品 Flow ではない）  
**Investigation revision / 調査 revision**: `c20942c`（`origin/main`）  
**Related / 関連**: [ai-workflow.md](../../rules/ai-workflow.md) §3–§5、[ai-review.md](../../rules/ai-review.md)、[system-test-strategy.md](../../rules/system-test-strategy.md)、[AGENTS.md](../../../AGENTS.md)、`prompts/03-implement.md`、`prompts/05-merge.md`

## Goal / Scope

- Problem / success condition — 解決したい問題・成功条件: 変更が積み重なるとき、実装者の一つの context が full verification まで抱えることと、子 head の成功を後の統合 head の成功と取り違えることを分けて扱う。成功は、意味・権限・独立レビュー・System-primary を弱めずに、どこまで現行契約で決まり、どこからが未決かを固定すること。
- Scope — 今回の Scope: 2026-10-02 の観測を経緯として残す。現行契約が既に定める「証拠は出した revision に限る」「Epic は integration verification まで完了しない」「子 head の必須検証は減らない」を実行契約と merge prompt に明示する。
- Non-goals / required follow-up — Non-goals / 後続必須: 子 Issue の SIT 実行を Epic へ移すこと、required commands の実行主体を reviewer または CI へ移すこと、prompt 番号を 06 / 07 に増やすことは、この記録では採用しない。
- Contracts to preserve — 維持する契約: 人間は Intent / Scope / Answers / Risk acceptance を持つ。AI は合意済みの意味を実行する。独立レビューは実装者の自己レビューではない。System は永続化と境界をまたぐ backend 挙動の primary である。未実行・失敗・pending は成功ではない。

## Current facts / 現状の事実

Kakeibo の数値は、この変更では再計測していない。2026-10-02 の観測メモとして扱う。Human-on-Exception の契約事実は `c20942c` のファイルで確認した。

| Fact / 事実 | Evidence path, symbol, revision / 根拠 | Affected route / 影響経路 |
|---|---|---|
| 完了前に、対象領域の `make lint` / `make test` が必要で、構造変更では `make survey` も必要 | `AGENTS.md` completion requirements、`c20942c` | 各変更の完了 |
| 各 Issue は AC と completion `make` を持ち、PR は実行した revision の結果を記録する。実行しただけ、または ID があるだけでは成功ではない | `docs/rules/ai-workflow.md` §3–§4 | Issue / PR |
| Epic は、子 Issue と integration verification が完了するまで閉じない | `docs/rules/ai-workflow.md` §5 | Epic |
| 永続化と境界をまたぐ backend 挙動では System が primary であり、完了は `make test`、Flow / SYS / FE の変更では `make survey` | `docs/rules/system-test-strategy.md` §7 および System-primary | SIT |
| 実装者の自己レビューは独立レビューにならない | `docs/rules/ai-review.md` | review |
| 2026-10-02 の観測では、自己レビューだけを外す追加指示は、make と PR 後の独立レビューまで省略させなかった | 観測メモ。Kakeibo PR #9–#11 の本文として記録されている。この変更では PR 本文を再取得していない | 指示の解釈 |
| 同じ観測の Cursor export 13 run では Total 36,407,858 のうち Cache Read が 34,657,280（95.2%） | 観測メモが引用する CSV 集計。この変更では CSV を再計算していない | token の読み方 |
| 約 $28 は残高推移からの概算であり、CSV の Cost は `Free` で、工程別の内訳は無い | 観測メモ自身の留保 | 単価の外挿 |
| reviewer 側の修正で Docker CLI が無く、`make lint` / `make test` / `make smoke` を完走できなかった記録がある | 観測メモが Kakeibo PR #9 として挙げる記録。この変更では再確認していない | 実行主体 |

## Risks / Unknowns / Assumptions

| Kind / 区分 | Detail + impact / 内容・影響 | Evidence / 根拠 | Owner / 対応・判断者 |
|---|---|---|---|
| Unknown | full make が token / cost の何 % か不明。工程を分けても総額が減るかは未計測 | CSV に工程別 attribution が無い、という観測メモの留保 | Q1 の実験が無い限り契約は変えない |
| Risk | SIT 実行を Epic まで遅らせると、DB・認可・transaction・境界をまたぐ欠陥の発見が遅れる | System-primary。観測メモも C 案を実験扱いとしている | Q1。未回答の間は現行の子 head 検証を維持 |
| Risk | reviewer に make を移すと、実行環境が足りないとき証拠が欠ける | 観測メモの Docker CLI 不在 | Q2。未回答の間は実装者が required commands を記録する |
| Assumption | 子 head の成功を、後の統合 head の成功と見なさない、という読みは現行 §4–§5 の範囲である | `ai-workflow.md` §4 の revision 証拠、§5 の Epic integration verification | AI。この PR で明示した。子の必須コマンドは減らしていない |

## Investigation dimensions / 検討観点

| Dimension | Result |
|---|---|
| Intent / boundary | 製品機能の追加ではない。検証の完了単位が対象。Q1 / Q2 以外は現行契約で足りる |
| Concepts / meaning | Done、provisional integration、product completion を同じ語にしない。子 head の完了は Epic の完了ではない |
| Actors | 製品の利用者主体ではない。実行主体は実装者、別コンテキストの reviewer、CI。誰を証拠の権威にするかは Q2 |
| Unit separation | 1 child head、Epic integrated head、最終 target head は別の証拠単位 |
| Input / uniqueness | N/A。入力の一意性はこの契約変更の対象外 |
| Create / update | N/A。API の POST / PUT は対象外 |
| UX continuity | N/A。画面遷移は対象外 |
| Failure | 未実行と成功を分けたままにする。統合後に初めて出る失敗は、子が clean だったことの否定ではない |
| Evidence / safety | System-primary、独立レビュー、revision に束縛された証拠を維持する |
| Cross-cutting | 子の証拠は統合 head の counterpart や cross-Flow を証明しない |
| Verification | 子 head の現行 required commands は維持する。粒度を下げるかは Q1 |

## Questions

### Q1 — 子 head の必須検証を、Epic 統合 head の full verification より狭くしてよいか

**English**

- Background / concrete example: Several child changes can each pass their own commands and still fail together on the Epic integrated head. One observation also showed a large token total that was mostly cache read, without a per-stage cost. The open proposal is to keep writing tests on the child, run a narrower command set there, and run full SIT, full make, and survey on the integrated head.
- Why human authority is required: Narrowing the child changes when a defect may be found and what "done" means for a merge into an Epic work branch. That is risk acceptance. The current rules do not allow a child to skip required commands and call the result success.
- A: Keep the current rule. Every child head records its own required lint, test, and survey when those rules apply. Epic integration verification is additional and runs on the integrated head.
- B: Targeted child. The child runs lint, static analysis, unit, integration, frontend contract, and the affected flow's system tests. The Epic integrated head runs the full system tests, full required commands, and survey. The child merge is provisional integration, not product completion.
- C: The child writes system-test artifacts but does not run them. The Epic integrated head runs system tests for the first time. Unit and contract tests still run on the child.
- Recommendation + reason: Keep A until a comparison measures token, cost, latency, and where defects are first found, through a clean integrated head. If an experiment is authorized, compare A and B. Do not adopt C from this record: it delays discovery of persistence and cross-boundary defects, and this record does not show that make is unnecessary.
- What remains blocked without an answer: Any rule, prompt, or CI change that lowers the commands a child head must run. The explicit statement that a child head does not prove the integrated head is not blocked.

**日本語**

- 背景・具体例: 子変更がそれぞれコマンドに成功しても、Epic の統合 head で同時に失敗しうる。別の観測では Total Tokens が大きく、その大半は cache read だったが、工程別の費用は無い。未採用の案は、子で tests を書き、子のコマンドは狭くし、full SIT、full make、survey は統合 head で行う、というものである。
- なぜ人間判断が必要か: 子の必須コマンドを狭めると、欠陥を見つける時点と、Epic 作業ブランチへの merge を完了と呼ぶ意味が変わる。これはリスクの受諾である。現行ルールは、子が required commands を省いた結果を成功と呼ばない。
- A: 現行を維持する。各子 head は、規則が適用される lint、test、survey を自分の head で記録する。Epic の integration verification はそれに追加され、統合 head で行う。
- B: 子は targeted。lint、静的解析、unit、integration、frontend contract、および影響する flow の system test を子が実行する。Epic の統合 head が full system test、full required commands、survey を実行する。子の merge は provisional integration であり、product completion ではない。
- C: 子は system test の成果物を作るが実行しない。Epic の統合 head が system test を初めて実行する。unit と contract は子で実行する。
- 推奨と理由: 統合 head が clean になるまでの token、cost、latency、欠陥の初出を比較するまで A を維持する。実験が許可されたら A と B を比べる。C はこの記録からは採用しない。永続化と境界をまたぐ欠陥の発見が遅れ、make が不要だとはこの記録は示していない。
- 未回答で止まる範囲: 子 head が実行するコマンドを下げる rule、prompt、CI の変更。子 head が統合 head を証明しない、という明示は止まらない。

### Q2 — required commands の証拠は、実装者、reviewer、CI の誰の実行か

**English**

- Background / concrete example: A recorded reviewer fix could not finish `make lint`, `make test`, and `make smoke` because the Docker CLI was absent. The command log did not attribute token cost by stage.
- Why human authority is required: Choosing the authority for completion evidence changes what is accepted as success when a laptop, a reviewer environment, and CI disagree. That is an operational risk decision. The current contract requires recorded command results for the target revision and does not name CI as a substitute.
- A: The implementer runs and records the required commands, as now. CI may also run. A missing reviewer toolchain does not move the duty to the reviewer.
- B: CI on that same revision is the completion evidence. The implementer may run commands locally, but a local log does not replace the CI result. The reviewer does not need the toolchain.
- C: The separate-context reviewer runs the required commands.
- Recommendation + reason: Keep A. C is a poor fit for the recorded environment gap. B is a possible later design only after the project states the CI workflow, the revision it must match, and the result when CI did not run. Do not treat an absent CI run as success.
- What remains blocked without an answer: Moving the required-command duty from the implementer to a reviewer or to CI.

**日本語**

- 背景・具体例: 記録された reviewer の修正は、Docker CLI が無く `make lint`、`make test`、`make smoke` を完走できなかった。コマンドのログは工程別の token 費用を持たない。
- なぜ人間判断が必要か: 完了証拠の権威を選ぶと、手元、reviewer 環境、CI が食い違ったときに何を成功とするかが変わる。これは運用上のリスク判断である。現行契約は対象 revision のコマンド結果を要求し、CI をその代替とは名付けていない。
- A: いまどおり実装者が required commands を実行して記録する。CI が同時に動いてもよい。reviewer の toolchain 不足は、義務を reviewer へ移さない。
- B: 同一 revision の CI を完了証拠にする。実装者は手元で実行してよいが、手元のログは CI 結果の代替ではない。reviewer は toolchain を持たなくてよい。
- C: 別コンテキストの reviewer が required commands を実行する。
- 推奨と理由: A を維持する。C は、記録された環境不足に合わない。B は、CI の workflow、一致させる revision、CI が未実行のときの結果をプロジェクトが定めてから検討する。CI が無いことを成功にしない。
- 未回答で止まる範囲: required commands の義務を、実装者から reviewer または CI へ移すこと。

## Answers / Decision history — 回答・決定履歴

| Q-ID | Answer | Reason / 理由 | Source + date/reference / 回答元 | Status / 置換先 |
|---|---|---|---|---|
| Q1 | unanswered / 未回答 | 推奨は回答ではない | — | Open |
| Q2 | unanswered / 未回答 | 推奨は回答ではない | — | Open |

## AI technical decisions / AI の技術判断

| Item / 項目 | Decision / 判断 | Rule/code evidence / 根拠 | Why no human decision is required / 人間判断不要の理由 |
|---|---|---|---|
| 子 head と統合 head の証拠 | 子の成功は統合 head を証明しない。Epic の integration verification は統合 head で行う。子の required commands は減らさない | `ai-workflow.md` §4–§5 の既存文 | 新しい完了水準を作らず、既存の revision 拘束と Epic 完了条件を merge 時に読めるようにした |
| prompt 番号 | 06 を integration、07 を final merge として追加しない | 現行の 01–05 で足り、検証を狭める変更は Q1 が未回答 | 番号の追加は、未受諾の検証モデルを契約として見せる |
| make 不要 | 採用しない | 観測メモ自身が、工程別 attribution が無く、make 不要とは結論できないと書いている | 測定されていない費用削減を、検証義務の削除として扱わない |
| Total Tokens | 新規に読んだ量として扱わない | 観測メモの 95.2% Cache Read | 集計の読み方であり、契約変更の根拠ではない |

## Decision → Acceptance Criteria / 決定 → 受け入れ条件

| Q-ID / decision | AC-ID | Preconditions/action/observable result / 前提・操作・結果 | SYS / FE-ID or method | docs |
|---|---|---|---|---|
| 子 head と統合 head を分ける、という AI 判断 | AC-01 | 子 head の required commands と独立レビューが成功しても、Epic は統合 head の integration verification まで完了にしない。子の required commands は省略しない | workflow conformance の対応シナリオ | `ai-workflow.md` §5、`prompts/05-merge.md` |
| Q1 | — | 未回答のため AC にしない | — | このファイル |
| Q2 | — | 未回答のため AC にしない | — | このファイル |

## Unresolved / Deferred — 未決 / Defer

| Item / 項目 | blocker / defer | Reason + stopped scope / 理由・停止範囲 | Resume condition / follow-up Issue |
|---|---|---|---|
| targeted child と Epic full verification | Q1 | 欠陥の発見時点を変えるため、未回答の間は実装しない | Q1 が B または C と回答され、比較の測定単位が統合 head の clean までと指定されたとき |
| CI を完了証拠にする | Q2 | 未実行の CI を成功にしない条件が未決定 | Q2 が B と回答され、対象 workflow と revision の一致条件があるとき |
| 単体 Issue の full verification を別 stage に分ける | Q1 | Epic が無い変更でも、完了を名乗る head の required commands は現行のまま | Q1 が、Epic 以外でも検証を遅らせると回答したとき |

## Issue split / completion make — Issue 分割案 / 完了 make

実装 Issue は作らない。Q1 と Q2 が未回答であり、Ready ではない。この変更の完了コマンドは、リポジトリ構造の文書変更として make を実行しない、という依頼に従い未実行である。未実行は成功ではない。契約上の採用範囲は、上の AC-01 に限る。
