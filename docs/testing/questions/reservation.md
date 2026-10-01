# 予約 / Reservation — Questions

> Bilingual human-facing template. English and Japanese must preserve the same decision-relevant meaning. See [language-policy](../../rules/language-policy.md).

**Status / 状態**: Awaiting answers / 回答待ち  
**Pack / Flow ID**: proposed Pack `reservation`（未作成）。Flow は未作成。回答が揃ったあと、`RESERVE_CUSTOMER`（利用者が空きを見て予約し、自分の予約を取り消す）と `RESERVE_STORE`（店舗運営者が予約一覧・メニュー・スタッフ・営業時間・休業日を扱う）を案とする。  
**Investigation revision / 調査 revision**: `ebf32619749dbd06526ea74b4291d5133d16cc06`（HEAD）。作業ツリーには教材タスク CRUD の未コミット削除がある。予約の Current facts は HEAD にも作業ツリーにも無い。  
**Related / 関連**: [concept](../../concept/README.md)（product concept 0 件）、[ai-workflow §2](../../rules/ai-workflow.md)、[domain-decisions](../../rules/domain-decisions.md)、[questions template](../../templates/questions.md)。active ADR / Policy / flow / ui / validation / db は予約について 0 件。

この文書の推奨は回答ではない。Answer 欄が Open の項目を、実装も concept も ADR も Accepted にしてはならない。

## Goal / Scope

- Problem / success condition — 解決したい問題・成功条件: 小規模な店舗で、ログインした利用者が空き時間を見てメニューを予約できる。メニューごとに所要時間と料金が違う。スタッフを指名でき、指名なしでも予約できる。利用者はキャンセルできる。店舗側は予約一覧を見られ、営業時間と休業日を設定できる。同じ時間に予約が重ならない。決済は行わない。
- Scope — 今回の Scope: 上記の成功条件を満たす予約の意味を確定すること。実装に進むのは、このファイルの human-authority blocker が 0 件になってから。
- Non-goals / required follow-up — Non-goals / 後続必須:
  - 決済、与信、返金、割引、税計算は対象外（人間の依頼）。料金は案内の表示であり、支払いの約束ではない。
  - 前日通知は Q8 の回答まで対象に入らない。Q8 で今回外すと決めた場合、後続必須として通知を残す。
  - 1 回の予約に複数メニューを束ねない（暫定の範囲。下の Assumptions）。カットとカラーを同時に頼みたい場合は、回答時に指摘されれば follow-up Question にする。
  - メニューとメニューの間の準備時間、1 日に複数の営業区間（途中休憩で割る）、指名料、繰り返し予約、予約内容の日時変更（変更はキャンセル後の新規予約で表す、という暫定。Q6 とセットで人間が確定する）は、今回の依頼には無い。
- Contracts to preserve — 維持する契約: 予約プロダクトの既存契約は無い。維持するものは repo 全体の実行契約と、認証済みの書き込みに監査列を付ける規則（[audit-ui-persistence](../../rules/audit-ui-persistence.md)）だけである。教材のタスク CRUD の画面・API・DB を予約の契約として引き継がない。

## Current facts / 現状の事実

| Fact / 事実 | Evidence path, symbol, revision / 根拠 | Affected route / 影響経路 |
|---|---|---|
| 人間の依頼: ログイン、店舗ごとの予約枠、メニューごとの所要時間と料金、スタッフ指名、指名なし予約、キャンセル、店舗側の予約一覧、営業時間と休業日、同時刻の重複禁止。最初は小規模店舗向け。決済はまだ不要。前日通知は「できるとよさそう」であり、必須とは書かれていない。 | この調査の人間 Intent（2026-10-01） | 予約全体。通知の要否は Q8 |
| 予約について、現行挙動を定義する実装・System テスト・FE contract・flow / ui / validation / db・concept・Accepted ADR / Policy・Questions は無い。 | `docs/concept/README.md`（concept 0）、`docs/flow/README.md`（Flow 0）、`docs/testing/core-features.md`（bundle 0）、`docs/testing/adr/README.md`、`docs/testing/policy/README.md`、`docs/testing/questions/` に予約ファイルが無かった。`docs/` の予約・店舗の一致も 0 件。revision は上の SHA | UI / API / DB とも予約の経路は無い |
| repo は Laravel backend と Next.js frontend を正本の技術制約にする。Controller に業務判断を置かない、Service が規則を持つ、空きの計算や重複判定は `lib/<domain>` と Service に置く、といった層の分け方は AI の実行範囲である。 | [backend-quick](../../rules/backend-quick.md)、[frontend-quick](../../rules/frontend-quick.md)、README の Local startup | 実装工程。この Questions では人間に選ばせない |
| HEAD の教材はタスク CRUD であり、予約の主体・単位・空き・重複の意味を持たない。作業ツリーではその教材ファイルが未コミットで削除されている。削除結果も予約契約ではない。 | `git status` on `ebf32619749dbd06526ea74b4291d5133d16cc06`。`docs/testing/questions/task-crud.md` は作業ツリーから消えている | 予約の SoT に使わない。`make greenfield CONFIRM=1` は今回の調査では実行していない |

## Risks / Unknowns / Assumptions

[domain-decisions](../../rules/domain-decisions.md) に従い、概念・単位・主体・根拠の意味を調査する。適用基準・許容例・似ているが拒否する反例を記す。未知の概念を既存の近いものへ無理に対応付けない。

暫定の語彙（未受諾の設計モデル。回答で置き換わる）:

| 語 / Term | 暫定の意味 / Provisional meaning |
|---|---|
| 店舗 / Store | 営業時間・休業日・メニュー・スタッフ・予約の親。Q1 は「何店を 1 つのシステムが扱うか」であり、親が店舗であること自体は依頼文「店舗ごとに予約枠」から置く |
| 利用者 / Customer | ログインして空きを見る主体。施術を受ける人と同じかは Q5 |
| 店舗運営者 / Store operator | ログインしてその店舗の予約一覧と台帳を扱う主体。スタッフ全員がこの主体になるとは置かない |
| スタッフ / Staff | 店舗に属する指名対象。認証アカウントとは別の台帳（Assumptions） |
| メニュー / Menu | 店舗に属する施術。名前・所要時間・案内料金を持つ。1 予約に 1 メニュー（Assumptions） |
| 候補の開始時刻 / Candidate start | 読み取り時に計算する空き。保持した枠レコードではない |
| 確定予約 / Confirmed reservation | 書き込みが成功した予約。空き時間を占める |
| キャンセル / Cancellation | 確定予約を、空きを占めない終端状態へ移す。Q6 |

許容例（依頼から置ける）: 利用者がメニューを選び、空いている開始時刻を選んで確定する。指名すればそのスタッフ、指名なしでも確定できる。店舗運営者がその店の予約一覧を見る。

似ているが、依頼からは拒否して新規概念にしない反例: タスク CRUD の「タスク」を予約に読み替えること。決済の「注文」を予約に読み替えること。美容室一般の慣習（指名料、担当スキル、電話予約、準備時間）を、書いていない要求として取り込むこと。

| Kind / 区分 | Detail + impact / 内容・影響 | Evidence / 根拠 | Owner / 対応・判断者 |
|---|---|---|---|
| Assumption | スタッフは指名対象の台帳であり、ログイン主体ではない。予約一覧を見るのは店舗運営者。スタッフ個人のマイカレンダーは今回の依頼に無い。これを後から足すと、見える予約の範囲が変わる。 | 依頼は「スタッフを指名」と「店舗側は予約一覧」 | Assumptions。人間がスタッフ個人ログインを要求した時点で Question に上げる |
| Assumption | 1 予約はメニュー 1 件。所要時間と案内料金はその 1 件から取る。複数メニューの合計時間は作らない。 | 依頼は「メニューごとに時間と料金」 | Assumptions。複数同時施術が必要なら follow-up |
| Assumption | その店舗の有効なスタッフは、その店舗の全メニューを担当できる。担当不可メニューの対応表は持たない。 | 担当範囲は未記載。カテゴリ慣習でスキル表を作らない | Assumptions。担当制限が必要なら follow-up。そのときは Q7 と同型の「対応表の事後変更が既存予約を書き換えるか」を改めて問う |
| Assumption | 施術と施術の間の準備時間は 0。ある予約の終了時刻と次の開始時刻が一致してもよい。 | 「重ならない」は時間の共通部分を禁じる読み。隙間の要求は無い | AI technical。準備時間が必要なら Question |
| Assumption | 営業日の解釈は 1 つのタイムゾーン。店舗のタイムゾーン初期値は `Asia/Tokyo`。前日はそのゾーンの暦日。複数地域は依頼に無い。 | 日本語の小規模店舗の依頼。repo はタイムゾーンを予約仕様として持たない | AI technical。別ゾーンが必要なら Question |
| Assumption | 利用者の登録項目は表示名・メールアドレス・パスワード。電話番号は持たない。店舗の一覧は、Q5 で主体が利用者アカウントなら、その表示名・メニュー・担当・開始時刻・状態を見せる。 | ログインと一覧が見たい、という依頼 | Assumptions。連絡先の追加は privacy の追加なので、求められたら Question |
| Assumption | 利用者アカウントは本人がメールで登録する。店舗運営者の公開自己登録はしない。運営者の初期アカウントをどう配るかは、Q1 のあと実装工程の provisioning（AI）であり、公開サインアップの意味とは分ける。 | ログインの依頼と、運営台帳の分離 | AI。招待制に閉じたい場合だけ Question |
| Assumption | 候補時刻の表示は空きだけを示し、他の利用者の名前は出さない。利用者は自分の確定予約だけを見る。 | 「空いている時間を見る」と「店舗側は予約一覧」の分離 | AI technical（プライバシー）。公開カレンダーに名前を出す要求があれば Question |
| Risk | 前日通知をメールで送ると、メールアドレスの利用目的と外部送信コストが発生する。送信失敗で予約を消すと、通知と予約の意味が混ざる。 | Q8 | Q8 の回答が risk acceptance |
| Unknown | 確定済み予約が参照するメニュー所要時間・料金・スタッフ名・営業時間・休業日を、後からの台帳変更が書き換えてよいか、この文書の作成時点では決まらない。 | [01-define-greenfield](../../../prompts/01-define-greenfield.md) の時間方向の確認 | Q7 |
| Unknown | 「重ならない」の単位がスタッフか店舗全体か、指名なしが担当者を確定時に固定するかが決まらない。ここが決まらないと空き計算も保存も書けない。 | 依頼の並列条件 | Q2 |
| Unknown | 「予約枠」が、営業時間から計算する開始時刻か、店舗が事前に登録する固定枠かが、文面の両方に引っ張られる。 | 「店舗ごとに予約枠」と「メニューごとに時間が違う」 | Q3 |

## Investigation dimensions / 検討観点

| Dimension | 結果 / Result |
|---|---|
| Intent / boundary | 依頼の成功条件と決済除外を Current facts に固定した。通知の範囲は Q8。何店を扱うかは Q1。代理予約・店舗による新規予約は Q5。複数メニュー同時、スキル対応表、準備時間、スタッフ個人ログインは Assumption として明示し、受諾はしていない |
| Concepts / meaning | 候補の開始時刻（その場の計算）と確定予約（成功した書き込み）を分ける。決済前の仮押さえは、決済が Non-goal なので持たない。タスクや注文へは対応付けない。Q2 Q3 Q7 が意味の本体 |
| Actors | 認証主体（アカウント）、操作主体（利用者または店舗運営者）、台帳の所有者（店舗運営者）、施術を受ける人（Q5）、空きを探す人（利用者）を分けた。スタッフは台帳であり認証主体ではない（Assumption）。ログインや外部キーから「施術を受ける人＝ログイン利用者」とは置かない |
| Unit separation | 画面の 1 操作、確定予約 1 件、空き計算の 1 開始時刻、重複判定の単位（Q2）、メニュー編集の単位（台帳）は別。一覧の一括操作は依頼に無い。1 予約 1 メニューは Assumption |
| Input / uniqueness | 空きの刻みと営業時間の形は Q3 Q4。同一開始時刻への同時確定は、Q2 の意味が決まったあと AI が 1 件だけ成功させる（AI technical decisions）。省略された指名は Q2。料金の空欄は許さない（メニューの必須項目、AI）。準備時間 0 は Assumption |
| Create / update | 予約の作成は確定書き込み。キャンセルは削除ではなく終端状態への更新（Q6 の範囲内で AI が状態遷移にする）。日時の変更 API は今回の依頼に無い。台帳更新が既存予約を書き換えるかは Q7。衝突時のロールバック手順は、意味が決まったあとの transaction であり人間の選択ではない |
| UX continuity | 入口はログイン。Q1 が複数店なら店舗選択が先に入る。その後はメニュー → 指名または指名なし → 候補開始時刻 → 確定 → 自分の予約。候補 0 件はエラーではなく「空いていない」。Q5 が店舗作成を含むときだけ、運営者の作成導線を足す。未回答の間は画面を確定しない |
| Failure | 空き 0 件は成功した空結果。未ログインは認証失敗。重複は Q2 の衝突であり、枠が消えたわけではない。通知失敗の扱いは Q8 が採用されたときの条件（予約は残す）。外部の決済失敗は N/A（決済が Non-goal） |
| Evidence / safety | 確定予約だけが時間を占める。候補時刻は事実としての予約ではない。監査列は会員向け書き込みの既存規則に従う。メール通知の外部送信は Q8 の risk acceptance。休業日が既存予約を消すかは Q7（破壊的操作の許可） |
| Cross-cutting | 予約の対になる既存機能は無い。生成型や公開 API の相手先も無い。教材タスクの route を予約の対にしない |
| Verification | 実装前。回答後に、重複の拒否・キャンセル権限・台帳変更が既存予約を拒むこと、空き 0 件と認証失敗の区別、を `*-SYS-*` と `*-FE-*` で見る。前日通知を外す場合、外部メールの System テストは理由付き N/A。今はテストを書かない |

## Questions

### Q1 — 1 つのシステムが扱う店舗の数と、運営者が見える範囲 / How many stores one system operates, and what an operator can see

**English**
- Background / concrete example: The request says reservation slots are per store, and the first users are small shops. Example: Mika runs one salon. Ken runs two salons and wants both calendars in one login. A customer wants to book without first picking a shop from a directory.
- Why human authority is required: All three readings satisfy the written request, and they change the promise of whose calendar you are looking at. File layout and a `stores` table do not decide this. In every reading, a store remains the owner of hours, menus, staff, and reservations.
- A: One running system serves one store. The customer never picks a store. One operator account manages that store's whole reservation list and settings. A second shop is a later product change, not a second calendar inside this scope.
- B: One system holds many stores. The customer chooses a store, then sees that store's open times. An operator account belongs to exactly one store and cannot see another store's reservations, menus, staff, or hours.
- C: Same multiple stores as B, and one operator account may manage more than one store, including seeing those stores' reservation lists.
- Recommendation + reason: A. The request is a small shop taking bookings, and "per store" says who owns a slot. It does not say the product is a directory of shops. B and C add a shop-selection promise and an isolation promise that were not asked for. The store entity still exists under A, so the owner of a slot is the store.
- What remains blocked without an answer: Customer entry (whether a store is chosen), operator authorization scope, and how many stores' lists exist. Booking overlap rules can be specified later under whichever boundary is chosen, but no reservation write is in scope until this is answered.

**日本語**
- 背景・具体例: 依頼は「店舗ごとに予約枠」かつ「最初は小規模店舗向け」。例: 美香さんの店は 1 軒だけで、利用者は店を選ばずに空きを見たい。健さんの場合は 2 軒を 1 つのログインで両方見たい。
- なぜ人間判断が必要か: 3 つの読みがどれも依頼文と両立し、見ているカレンダーが誰の店のものかが変わる。`stores` テーブルを置くかどうかでは決まらない。どの案でも、営業時間・メニュー・スタッフ・予約の親は店舗のままである。
- A: 動いている 1 つのシステムは 1 店舗だけを扱う。利用者は店舗を選ばない。運営者アカウントはその店舗の予約一覧と設定のすべてを扱う。2 軒目は今回の範囲の外であり、あとから別の製品判断になる。
- B: 1 つのシステムに複数店舗がある。利用者は先に店舗を選び、その店の空きだけを見る。運営者アカウントはちょうど 1 店舗に属し、他店の予約・メニュー・スタッフ・営業時間は見えない。
- C: 店舗が複数ある点は B と同じ。加えて 1 つの運営者アカウントが複数店舗を管理でき、それらの予約一覧も見る。
- 推奨と理由: A。依頼は小規模な店が予約を受けることであり、「店舗ごと」は枠の持ち主が店舗だという指定である。店の一覧から選ばせる約束は書かれていない。A でも店舗は台帳の親として残る。
- 未回答で止まる範囲: 利用者が最初に店舗を選ぶかどうか、運営者の見える範囲、一覧が何店分あるか。重複ルールの文言は境界が決まってから書けるが、この回答の前に予約の書き込みは範囲に入れない。

### Q2 — 何が時間を占め、指名なしは誰の予約になるか / What occupies time, and who a no-nomination booking belongs to

**English**
- Background / concrete example: A store has two staff, Yamada and Sato. A cut takes 60 minutes. There is already a confirmed booking for Yamada at 10:00–11:00. A customer wants Sato at 10:00. Another customer wants no nomination at 10:00. A third customer wants Yamada at 11:00.
- Why human authority is required: "Do not overlap", "nomination", and "no nomination" can mean three different promises. Choosing a database lock does not choose which promise is true. The service recipient's identity is Q5; this question decides the resource that is occupied when the subject is allowed to book.
- A: Overlap is per staff. Yamada at 10:00 still leaves Sato bookable at 10:00. A no-nomination booking is accepted only when at least one staff member is free for the whole menu duration, and at confirmation the system assigns the first free staff in the store's display order and stores that staff on the reservation. The customer sees that staff name after confirmation. The same customer account may not hold two confirmed reservations whose times intersect. 10:00–11:00 may be followed by 11:00–12:00 for the same staff.
- B: Overlap is still per staff, but a no-nomination booking stores no staff name. It consumes one anonymous unit of remaining free staff for that interval. The list keeps saying "no nomination". This scope does not include the operator later attaching a person. The same customer-account intersection rule as A applies.
- C: The whole store accepts only one confirmed reservation at a time. Staff is a label, not a time resource. Yamada and Sato cannot both be booked at 10:00. No-nomination uses that same single store slot. The same customer-account intersection rule as A applies.
- Recommendation + reason: A. The request asks for a named person and also for booking without a name, and for those bookings not to collide. C makes the name decorative. B leaves the customer without a person even after confirmation, which needs a later assignment step nobody asked for. A makes the promise "this time with this person" true at confirmation, including no-nomination. Back-to-back bookings are allowed because no gap between services was requested (Assumption).
- What remains blocked without an answer: The availability query, the confirmation write, the conflict result, and the store list's "who is assigned" column. If Q5 says the service recipient is not the customer account, the "same account may not overlap" clause is re-opened as a follow-up, because a typed-in name is not a reliable person id.

**日本語**
- 背景・具体例: スタッフは山田さんと佐藤さん。カットは 60 分。山田さんの 10:00–11:00 は確定済み。別の利用者が 10:00 の佐藤さんを指名したい。別の利用者は 10:00 を指名なしで取りたい。さらに別の利用者が山田さんの 11:00 を取りたい。
- なぜ人間判断が必要か: 「重ならない」「指名」「指名なし」は、3 つの別の約束として読める。DB のロックの種類では、どの約束が正しいかは決まらない。施術を受ける人の同一性は Q5。この質問は、予約が許されるときに時間を占める資源を決める。
- A: 重なりはスタッフごと。山田さんが 10:00 でも、佐藤さんが空いていれば 10:00 の佐藤指名はできる。指名なしは、メニューの所要時間ぜんぶが空いているスタッフが 1 人以上いるときだけ確定でき、確定時に店舗の表示順で最初の空きスタッフを 1 人割り当てて予約に記録する。利用者には確定後にその担当名を見せる。同一の利用者アカウントは、時間が交わる確定予約を 2 件持てない。同じスタッフの 10:00–11:00 の直後の 11:00–12:00 は重なりではない。
- B: 重なりはスタッフごとだが、指名なしは担当名を記録しない。その時間帯に残っている空きスタッフ 1 人分を、名前の無い 1 件として消費する。一覧の表示は「指名なし」のまま。運営者が後から担当を付ける機能は今回持たない。同一アカウントの時間交差を禁じる点は A と同じ。
- C: 店舗全体で同時に確定予約は 1 件だけ。スタッフは時間の資源ではなくラベル。山田さんと佐藤さんを 10:00 に両方は予約できない。指名なしもその同じ 1 枠を使う。同一アカウントの時間交差を禁じる点は A と同じ。
- 推奨と理由: A。依頼は人を指名できることと、指名しなくても予約できること、そしてそれらが衝突しないことを同時に求めている。C では指名は飾りになる。B では確定したあとも担当が決まらず、依頼に無い後付け作業が残る。A は「この時間のこの人」が確定時に真になる。施術の隙間は依頼に無いので、終了時刻と次の開始時刻が同じでも重なりではない。
- 未回答で止まる範囲: 空きの計算、確定の書き込み、衝突の結果、一覧の担当列。Q5 で施術を受ける人が利用者アカウントでないと分かった場合、同一アカウントの交差禁止は follow-up で開け直す。入力された名前は同一人物の識別に使えない。

### Q3 — 利用者が選ぶ時刻は、計算した空きか、事前登録の枠か / Are offered times computed openings or pre-registered slots?

**English**
- Background / concrete example: Open 10:00–19:00. A cut is 60 minutes and color is 90 minutes. Under a computed model, a cut can start at 10:00 or 10:30, while color only appears where 90 free minutes fit. Under a pre-registered model, the store authors rows such as "cut 10:00–11:00" and the customer can pick only those rows.
- Why human authority is required: The request says both "slots per store" and "duration differs by menu". Those phrases point at different products. Grid storage is an implementation choice; what the customer is allowed to select is not.
- A: The store does not author individual slots. Open times are computed from weekly hours (Q4), closed dates, existing confirmed reservations, and the selected menu duration. Offered start times step by a store-configurable interval whose initial value is 30 minutes. A start is offered only when the whole duration fits inside that day's open interval and satisfies Q2. Changing the menu duration changes which starts are offered for future bookings only (interaction with Q7).
- B: The store pre-registers concrete slots, per menu or shared by the store, each with its own start and end. The customer can choose only a registered slot. If the menu duration does not equal the slot length, that slot cannot be booked. Hours and closed dates still suppress slots that fall outside them.
- Recommendation + reason: A. Different durations were requested. Pre-registered slots copy those durations into another list that goes stale when a menu or the hours change. "Slot" here is the bookable start the store's calendar allows.
- What remains blocked without an answer: The customer time-selection screen and the availability API. Store settings for hours still depend on Q4 and Q7.

**日本語**
- 背景・具体例: 営業は 10:00–19:00。カット 60 分、カラー 90 分。計算方式なら、カットは 10:00 や 10:30 を選べ、カラーは 90 分入る時刻だけが出る。事前登録方式なら、店舗が「カット 10:00–11:00」のような行を作り、利用者はその行だけを選ぶ。
- なぜ人間判断が必要か: 依頼には「店舗ごとに予約枠」と「メニューごとに時間が違う」が両方ある。この二つは別の製品を指す。枠をどのテーブルに置くかは実装であり、利用者が何を選んでよいかは実装では決まらない。
- A: 店舗は個別の枠を登録しない。空きは、曜日の営業時間（Q4）、休業日、既存の確定予約、選んだメニューの所要時間から計算する。開始時刻の刻みは店舗が設定でき、初期値は 30 分。その日の営業区間に所要時間ぜんぶが収まり、かつ Q2 を満たす開始だけを出す。メニュー所要時間の変更が未来の空きだけに効くか、確定済みまで書き換えるかは Q7。
- B: 店舗が、メニューごとまたは店舗共通で、開始と終了を持つ枠を事前に登録する。利用者はその登録枠だけを選べる。メニューの所要時間が枠の長さと違えば、その枠は予約できない。営業時間と休業日からはみ出す枠は出せない。
- 推奨と理由: A。所要時間がメニューごとに違う、と依頼されている。事前登録の枠は、その時間をもう一つの一覧に複製し、メニューや営業時間を変えたときに古くなる。ここでの枠は、店舗のカレンダーが許す開始時刻である。
- 未回答で止まる範囲: 利用者の時刻選択と、空きを返す API。営業時間の設定画面自体は Q4 と Q7 にも依存する。

### Q4 — 営業時間は曜日ごとか、毎日同じか / Do business hours vary by weekday?

**English**
- Background / concrete example: The store is open 10:00–19:00 on other days and does not open on Tuesday. 2026-10-13 is a holiday even though it is a weekday they are usually open. A customer looks at Tuesday and at that holiday.
- Why human authority is required: "Business hours" plus "closed days" can be one weekly pattern plus date exceptions, or one daily window plus date exceptions. That changes what the operator can express without creating 52 dated rows. It is not a form-layout choice.
- A: Each weekday has at most one open interval, which may be "closed". A specific calendar date may be marked closed, and that closed date suppresses openings even if the weekday is normally open. One day is not split into morning and afternoon intervals. Removing a closed date or widening hours only creates new candidate starts; it does not rewrite confirmed reservations (detailed collision rules are Q7).
- B: The store has one open interval shared by every day of the week, plus specific closed dates. A regularly closed weekday is expressed by adding those dates, not by a weekday pattern.
- Recommendation + reason: A. The request includes both ongoing hours and closed days. A single shared interval cannot express a regularly closed weekday except by listing dates. A does not assume which weekday is closed; the store sets that.
- What remains blocked without an answer: The hours/closed-day settings and the inputs to Q3's availability calculation.

**日本語**
- 背景・具体例: 火だけ休みで、他の曜日は 10:00–19:00。2026-10-13 は普段なら開いている曜日だが、その日だけ休み。利用者が火曜と、その休日を見る。
- なぜ人間判断が必要か: 「営業時間」と「休業日」は、曜日の型に日付の例外を足す製品にも、全日共通の 1 区間に日付の例外を足す製品にも読める。運営者が 52 日分の日付を作らずに何を表現できるかが変わる。フォームの見た目の問題ではない。
- A: 曜日ごとに開いている区間は最大 1 つ。閉まっている曜日は区間なし。特定の日付を休業にでき、その日付は曜日が普段開いていても空きを出さない。1 日を午前と午後に分割しない。休業日を外す、または営業を長くするのは、新しい候補時刻が増えるだけであり、確定予約の中身は書き換えない（衝突する短縮や休業の保存規則は Q7）。
- B: 週のすべての日で共通の開いている区間が 1 つと、特定日付の休業日がある。毎週火曜を休みにするには、その日付を休業日として登録する。
- 推奨と理由: A。依頼は継続する営業時間と休業日の両方を含む。全日共通の 1 区間では、毎週決まった曜日の休みを日付の列挙でしか表せない。どの曜日を閉めるかは店舗が決め、A はそれを決めつけない。
- 未回答で止まる範囲: 営業時間・休業日の設定と、Q3 の空き計算への入力。

### Q5 — 施術を受ける人は誰か。店舗は予約を作れるか / Who receives the service, and may the store create a reservation?

**English**
- Background / concrete example: A logged-in customer, Aoi, books a cut. Separately, a person phones the store, has no account, and the operator wants to put "Ken, 15:00" on the same calendar. Another logged-in customer wants to book for their child, not for themselves.
- Why human authority is required: The booking actor, the account, and the person who receives the service are different roles. The request says the user looks at open times and books, and the store wants to see the list. It does not say the store creates bookings or that the logged-in person is always the recipient. That must not be inferred from the login form.
- A: Only a logged-in customer creates a reservation, and the recipient is that customer account. There is no field for another person's name. The operator does not create reservations. The operator views the list, edits store settings, and cancels only within Q6. The store list shows that customer's display name.
- B: A customer can still book for themselves as in A. In addition, the operator can create a reservation by entering a visitor name and a contact for someone who has no account. That reservation's recipient is the entered visitor, not a customer account. How two typed names count as the same person for Q2's overlap rule is not decided by this option; it becomes a follow-up if B is chosen.
- C: A logged-in customer may book for another named person. The operator still does not create reservations. The recipient is the name entered at booking, not the account. The same follow-up about same-person overlap applies.
- Recommendation + reason: A. The request's booking actor is the user who looks at open times, and the store's requested action is to view the list. B and C introduce a recipient who is not an account. That is a real salon operation, and it is a different promise, so it stays an option rather than an assumption.
- What remains blocked without an answer: Who is allowed to call the confirmation write, which name is stored on the reservation, and whether Q2's same-person rule has a reliable id. Customer self-registration (display name, email, password) is the assumed account path only together with A.

**日本語**
- 背景・具体例: ログインした葵さんが自分のカットを予約する。別件として、アカウントの無い人から電話があり、運営者が「健さん 15:00」を同じカレンダーに入れたい。別のログイン利用者は、自分ではなく子どもの名前で予約したい。
- なぜ人間判断が必要か: 予約を操作する人、アカウント、施術を受ける人は別の役割である。依頼は、利用者が空きを見て予約することと、店舗が一覧を見ることである。店舗が予約を作ることや、ログインした人が必ず施術を受けることは書かれていない。ログイン画面からそれを推論しない。
- A: 予約を作れるのはログインした利用者だけで、施術を受ける人はその利用者アカウントである。他人の名前欄は無い。運営者は予約を作らない。運営者が行うのは一覧の閲覧、店舗設定の編集、および Q6 の範囲のキャンセル。一覧にはその利用者の表示名が出る。
- B: 利用者は A と同様に自分の予約を作れる。加えて運営者は、アカウントの無い来店者の名前と連絡先を入れて予約を作れる。その予約の施術を受ける人は、入力された来店者であり、利用者アカウントではない。入力された二つの名前を Q2 の「同一人物の重なり」で同一とみなす規則は、この選択肢では決まらない。B を選んだ場合の follow-up にする。
- C: ログインした利用者が、別の人の名前で予約できる。運営者は予約を作らない。施術を受ける人は予約時に入力した名前であり、アカウントではない。同一人物の重なりについての follow-up は B と同じ。
- 推奨と理由: A。依頼が予約の操作者としているのは空きを見る利用者であり、店舗に頼んでいる操作は一覧を見ることである。B と C はアカウントではない施術対象を増やす。それは店舗運営として成り立つ別の約束なので、Assumption にせず選択肢に残す。
- 未回答で止まる範囲: 確定の書き込みを誰が呼べるか、予約にどの名前を残すか、Q2 の同一人物ルールに使える識別があるか。表示名・メールアドレス・パスワードによる利用者の自己登録は、A と組になるときのアカウント手順である。

### Q6 — 誰が、いつまで、キャンセルできるか / Who may cancel, and until when?

**English**
- Background / concrete example: Aoi has a confirmed cut on Friday at 15:00. On Thursday night Aoi wants to cancel. At Friday 15:10 Aoi has not arrived and the operator wants the slot not to remain a confirmed booking. Aoi cancels by mistake and wants the same reservation record restored. There is no fee, because payment is out of scope.
- Why human authority is required: "The user can cancel" does not say whether the operator can cancel, whether a deadline exists, or whether cancellation is reversible. Cancellation frees time under Q2, so the authority is part of the overlap promise. It is also the destructive transition for an already confirmed record.
- A: The customer who owns the reservation may cancel it only before the start time. After the start, that customer cannot cancel it. The operator may cancel any confirmed reservation of their store, whether the start is still in the future or already past. Cancellation immediately frees the interval for a new booking when the interval is still inside current open hours and in the future. A cancelled reservation cannot return to confirmed. Booking again creates a new reservation. No fee is charged. There is no separate no-show state; an operator cancel is how a missed visit is recorded.
- B: The owning customer may cancel any time before the start. The operator cannot cancel. After the start, nobody cancels; the row stays confirmed as history.
- C: The customer may cancel only until a cutoff the store configures (for example, the previous local day). After that cutoff, only the operator may cancel, with the same terminal effect as A. Choosing C requires the cutoff's initial value to be stated in the answer; otherwise C is treated as ambiguous and asked again.
- Recommendation + reason: A. The user asked to cancel, and the store must be able to release a future staff interval when the customer will not come, otherwise Q2's "this staff is free" stays false. A configurable deadline was not requested. Restoring the same row would make cancellation reversible without being requested; a new reservation keeps the history of the cancelled one.
- What remains blocked without an answer: The cancel action, who sees it, whether the freed time reappears in Q3, and the reservation's terminal state. Reschedule-in-place stays out of scope under every option here; a different time is a new reservation after cancel, unless a later answer adds that meaning.

**日本語**
- 背景・具体例: 葵さんのカットが金曜 15:00 で確定している。木曜の夜に葵さん自身が取り消したい。金曜 15:10 になっても来店がなく、運営者は確定のまま残したくない。葵さんが誤って取り消したあと、同じ予約行を確定に戻したい。決済は範囲外なので、キャンセル料は無い。
- なぜ人間判断が必要か: 「キャンセルできる」は、運営者も取り消せるか、期限があるか、取り消した予約を元に戻せるかを決めない。キャンセルは Q2 の時間を空ける操作なので、重複の約束の一部である。確定済み記録に対する破壊的な遷移でもある。
- A: その予約の利用者は、開始時刻より前だけキャンセルできる。開始後は利用者はキャンセルできない。運営者はその店舗の確定予約を、開始が未来でも過去でもキャンセルできる。キャンセルすると、その区間が現在の営業時間の中かつ未来なら、すぐ新しい予約の対象になる。キャンセルした予約は確定へ戻せない。取り直す場合は新しい予約を作る。料金は取らない。無断欠席という別状態は持たない。来なかった記録は運営者のキャンセルで表す。
- B: 予約の利用者は開始より前ならキャンセルできる。運営者はキャンセルできない。開始後は誰もキャンセルせず、行は履歴として確定のまま残る。
- C: 利用者のキャンセルは、店舗が設定する期限まで（例: 前日の現地日付のうち）に限る。期限後にキャンセルできるのは運営者だけで、終端の効果は A と同じ。C を選ぶときは、回答の中に期限の初期値を書く。初期値が無い C は曖昧なので、もう一度問う。
- 推奨と理由: A。依頼は利用者のキャンセルを含み、来ないと分かっている未来のスタッフ時間を店舗が空けられないと、Q2 の「このスタッフは空いている」が偽のままになる。期限の設定は依頼されていない。同じ行を確定に戻すことも依頼されていない。取り消した記録を残し、新しい予約を別に作る。
- 未回答で止まる範囲: キャンセル操作、誰に見せるか、空いた時間が Q3 に戻りうるか、予約の終端状態。どの選択肢でも、確定済みの日時をその行のまま書き換える機能は範囲外である。別の時刻が欲しい場合は、キャンセルしたあとの新しい予約である。あとからその意味を足す回答があれば、そのときに follow-up する。

### Q7 — 台帳を変えたとき、すでに確定した予約は書き換わるか / Do later master changes rewrite confirmed reservations?

**English**
- Background / concrete example: On March 1 a customer confirms a cut for March 10, 10:00–11:00, 60 minutes, displayed price 5000, staff Yamada. After that confirmation the store edits the cut to 90 minutes and 6000, renames Yamada to Yamamoto or deactivates Yamada, marks March 10 closed, or moves the closing time to 10:30. Separately, the store extends closing from 19:00 to 20:00, which collides with nobody.
- Why human authority is required: A confirmed reservation refers to mutable menu, staff, hours, and closed dates. The product meaning does not say whether a later edit affects only future bookings or also reinterprets the confirmed record. Automatic cancellation would destroy confirmed bookings. Leaving the choice to the update statement is not allowed.
- A: A confirmed reservation keeps the menu name, duration, displayed price, and staff display name from confirmation time. Later edits to the menu or staff name apply only to reservations confirmed after the edit. Existing duration, displayed price, and assigned staff do not change, so old bookings do not newly overlap because a menu got longer. Deactivating a staff member, deleting or disabling a menu, marking a date closed, or shortening hours is rejected while any future confirmed reservation would no longer fit that staff, menu, or open interval. The operator cancels those reservations first (Q6), then saves the setting. Widening hours or removing a closed date does not rewrite old reservations; it only adds candidate starts. Past reservations keep their snapshots and do not block a menu or staff member from being disabled.
- B: A reservation stores only references. Name, duration, price, and staff label are always read from the current master. Lengthening a menu moves the end of existing reservations and may create overlaps; those existing reservations remain. Closing a date or shortening hours does not auto-cancel and does not block the save.
- C: Snapshots of menu name, duration, price, and staff display name match A. Unlike A, marking a date closed or shortening hours auto-cancels every future confirmed reservation that would no longer fit. The customer is not asked. No-show is still not a separate state; these are cancellations.
- Recommendation + reason: A. B can make two already accepted bookings overlap, and it changes the duration and price the customer was shown. C cancels confirmed bookings as a side effect of a calendar edit. A keeps the confirmed promise and makes the destructive step an explicit cancel. Price remains informational because payment is out of scope; the snapshot is what the list shows for that booking, not a charge.
- What remains blocked without an answer: Edit and delete rules for menus, staff, weekly hours, and closed dates, and what a past or future row in the store list displays.

**日本語**
- 背景・具体例: 3 月 1 日に、3 月 10 日 10:00–11:00、60 分、表示料金 5000、担当山田でカットが確定した。そのあと店舗が、カットを 90 分・6000 に変える、山田を山本に改名する、または山田を無効にする、3 月 10 日を休業にする、閉店を 10:30 に早める。別の操作として、閉店を 19:00 から 20:00 に延ばす。こちらは既存予約と衝突しない。
- なぜ人間判断が必要か: 確定予約は、あとから変わるメニュー・スタッフ・営業時間・休業日を参照する。後の変更が未来の予約だけに効くのか、確定済みの記録の意味まで変えるのかは、製品の意味として決まっていない。自動キャンセルは確定予約を消す。更新 SQL の書き方にこの選択を預けない。
- A: 確定予約は、確定時点のメニュー名・所要時間・表示料金・スタッフ表示名を保持する。メニューやスタッフ名のその後の編集は、編集より後に確定した予約にだけ効く。既存の所要時間・表示料金・担当は変わらない。メニューを長くしたことで、古い予約どうしが新たに重なることは起きない。スタッフの無効化、メニューの削除または無効化、休業日の設定、営業時間の短縮は、未来の確定予約が新しいスタッフ・メニュー・営業区間に収まらなくなる間は保存できない。運営者は先にその予約をキャンセルし（Q6）、そのあと設定を保存する。営業を延ばす、または休業日を外す操作は、古い予約を書き換えず、候補の開始時刻が増えるだけである。過去の予約は写しを残すだけで、メニューやスタッフの無効化は止めない。
- B: 予約が持つのは参照だけである。名前・所要時間・料金・スタッフの表示は常に現在の台帳を読む。メニューを長くすると既存予約の終了が動き、重なりが生まれても既存予約は残る。休業日や営業時間の短縮は、自動キャンセルもしないし、保存も止めない。
- C: メニュー名・所要時間・料金・スタッフ表示名の写しは A と同じ。A と違い、休業日の設定と営業時間の短縮は、収まらなくなる未来の確定予約を自動でキャンセルする。利用者への確認は無い。無断欠席の別状態は持たず、これらはキャンセルである。
- 推奨と理由: A。B は、すでに成立した二つの予約を重ならせる可能性があり、利用者に見せた時間と料金を変える。C はカレンダー編集の副作用で確定予約を取り消す。A は確定時の約束を残し、壊す操作を明示的なキャンセルに限る。料金は決済の対象ではない。写しは、その予約の一覧に出す案内であり、請求ではない。
- 未回答で止まる範囲: メニュー・スタッフ・曜日営業・休業日の編集と削除の規則、店舗一覧の過去行と未来行に何を表示するか。

### Q8 — 前日通知を今回の範囲に入れるか。入れるならどの経路か / Is the day-before notice in this scope, and by which channel?

**English**
- Background / concrete example: A reservation for March 10 at 10:00 is confirmed. The phrase in the request is that a notice on the day before would be good. One reading sends nothing in this scope. Another sends an email at 18:00 on March 9 in the store timezone to the customer's login email. A third only shows "tomorrow" the next time the customer opens the app. If the customer books on March 9 at 19:00, the 18:00 send time has already passed.
- Why human authority is required: The wording is a wish, not a committed behavior. Email is an external message to a personal address and has delivery cost. In-app copy changes what "notice" promises. None of the repository rules choose a channel.
- A: Day-before notice is out of this scope. Confirmation and cancellation are visible in the application. No email or push is sent. Notice remains required follow-up work, not an accepted design. No message provider is configured for this feature.
- B: In scope, by email. At 18:00 on the local calendar day before the reservation date, send one email to the customer account's login email for each reservation that is still confirmed at send time. Do not email cancelled reservations. The body contains store name, local date and start time, menu name, staff name, duration, and the snapshotted displayed price. A booking created after that 18:00 sends nothing for that reservation; the confirmation screen is the notice. Delivery failure does not cancel or change the reservation. Choosing B accepts using the login email for this operational message and accepts an external mail provider. Marketing mail is not included.
- C: In scope, inside the application only. The next time that customer is logged in on the local day before the reservation, or on the reservation day, the application shows that a confirmed reservation is tomorrow or today. No email provider and no send-time job exist. A customer who never returns sees nothing.
- Recommendation + reason: A. The request says the notice would be good, which does not yet accept a channel, a clock time, or external delivery. The booking promise can be stated without it. B remains available when that risk is accepted. The 18:00 rule is part of B so the answer does not leave the send instant open.
- What remains blocked without an answer: Any notification job, template, and provider configuration. Options A and the booking core do not wait on a mail provider. The booking core still waits on Q1–Q7.

**日本語**
- 背景・具体例: 3 月 10 日 10:00 の予約が確定している。依頼の文言は、前日に通知できるとよさそう、である。ある読みでは今回は何も送らない。別の読みでは、店舗タイムゾーンの 3 月 9 日 18:00 に、利用者のログイン用メールへ 1 通送る。さらに別の読みでは、次にアプリを開いたとき「明日」と見せるだけである。3 月 9 日 19:00 に予約した場合、18:00 の送信時刻は既に過ぎている。
- なぜ人間判断が必要か: この文言は希望であり、確定した挙動ではない。メールは個人のアドレスへの外部送信であり、配信コストがある。アプリ内表示は「通知」の約束を変える。repo の規則は経路を決めない。
- A: 前日通知は今回の範囲外。確定とキャンセルはアプリ上で見える。メールもプッシュも送らない。通知は後続必須であり、受諾した設計ではない。この機能のためのメッセージ事業者が設定されることも無い。
- B: 今回の範囲に、メールで入れる。予約日の現地暦日の前日 18:00 に、その時点で確定のままの予約ごとに、利用者アカウントのログイン用メールへ 1 通送る。キャンセル済みには送らない。本文には店舗名、現地の日付と開始時刻、メニュー名、スタッフ名、所要時間、写しの表示料金を含める。その 18:00 より後に作られた予約には、その予約の前日メールは送らない。案内は確定画面である。送信に失敗しても予約はキャンセルせず、内容も変えない。B を選ぶことは、ログイン用メールをこの業務連絡に使うことと、外部のメール事業者を使うことを受諾することである。広告メールは含まない。
- C: 今回の範囲に、アプリの中だけ入れる。その利用者が、予約の現地前日または当日にログインしているとき、確定予約が明日または当日であることを表示する。メール事業者も、時刻起動の送信も無い。再度開かなかった利用者には何も届かない。
- 推奨と理由: A。依頼は「よさそう」であり、経路・時刻・外部配信の受諾にはなっていない。予約そのものの約束は通知なしで記述できる。リスクを受けるときは B を選べる。B には 18:00 を含めてあり、送信時刻を未決のまま残さない。
- 未回答で止まる範囲: 通知ジョブ、文面、事業者設定。A でも、予約本体はメール事業者を待たない。予約本体は Q1 から Q7 を待つ。

## Answers / Decision history — 回答・決定履歴

| Q-ID | Answer | Reason / 理由 | Source + date/reference / 回答元 | Status / 置換先 |
|---|---|---|---|---|
| Q1 | unanswered / 未回答 | — | — | Open |
| Q2 | unanswered / 未回答 | — | — | Open |
| Q3 | unanswered / 未回答 | — | — | Open |
| Q4 | unanswered / 未回答 | — | — | Open |
| Q5 | unanswered / 未回答 | — | — | Open |
| Q6 | unanswered / 未回答 | — | — | Open |
| Q7 | unanswered / 未回答 | — | — | Open |
| Q8 | unanswered / 未回答 | — | — | Open |

Do not copy the recommendation into Answer. Do not silently overwrite a previous answer.  
推奨を Answer に代入しない。改訂前の回答を黙って上書きしない。

## AI technical decisions / AI の技術判断

回答が Assumptions を維持している場合にだけ有効。回答が Assumption を破ったら、その行は無効になり follow-up Question に回す。

| Item / 項目 | Decision / 判断 | Rule/code evidence / 根拠 | Why no human decision is required / 人間判断不要の理由 |
|---|---|---|---|
| 層と配置 | Laravel は Controller → Service → Repository。判定と空き計算は Service。Next.js の表示状態は `src/lib/<domain>` の純粋関数。パスワードは framework の通常のハッシュ。トランザクション境界は複数書き込みをまとめる Service が持つ | backend-quick / frontend-quick | repo が AI に委譲済みの実装構造 |
| 候補と確定 | 開始時刻の候補は都度計算し、仮押さえ行は保存しない。時間を占めるのは確定予約だけ。決済前ホールドは作らない | 決済が Non-goal。候補を確定として表示しない（domain-decisions の evidence） | 依頼に仮押さえが無く、決済も無い |
| 同時確定 | Q2 の同一資源・同一区間に対する同時の確定は 1 件だけ成功し、もう一方は衝突を返す。画面は、その開始がもう選べない状態として空結果または衝突を見せる。成功した確定の再送は 2 件目を作らない | Input / uniqueness。backend-quick の transaction | 意味（Q2）が決まったあとの機械的な排他。誰を勝たせるかという別の製品規則は無い |
| 区間 | 占有は半開区間。終了時刻と次の開始が一致する予約は重ならない。準備時間は 0 | Assumptions。依頼に隙間が無い | 「重ならない」の通常の集合演算。準備時間は新しい意味なので、求める声があれば Question |
| タイムゾーン | 店舗は 1 つの IANA ゾーンを持ち、初期値は `Asia/Tokyo`。営業日・前日・Q8-B の 18:00 はそのゾーンの現地時刻 | Assumptions | 複数地域は依頼に無い。ゾーンの実装型は技術 |
| 認証の中身 | 利用者はメールとパスワードで本人登録し、ログインする。運営者は公開登録しない。認証エンドポイントには framework の通常の throttling を付ける。リセット手順はログインに含める | 依頼のログイン。Failure の rate limit | 認証方式の製品差は出ていない。招待制だけが追加の意味 |
| 他人の予約の非表示 | 空き照会は他の利用者の名前を含まない。利用者は自分の予約だけ読む。運営者は Q1 の範囲の店舗一覧だけ読む | 「空き」と「店舗の一覧」の分離 | 名前の公開は依頼されておらず、プライバシーを広げないための既定 |
| 監査 | 利用者・運営者の確定、キャンセル、台帳更新は、既存の監査規則に従い操作者を残す | audit-ui-persistence | 既存の反復規則。新しい監査方針ではない |
| 料金の単位 | 案内料金は整数で保持し、請求・税・割引は持たない | 決済 Non-goal | 表示値の型。通貨単位を円以外にする要求は無い |
| Pack 案 | Pack 名 `reservation`。Flow は未作成。実装 Issue の許可パスは、backend の予約ドメイン（Controller / Service / Repository / DTO / Model / Request / migration）と frontend の予約ドメイン（`app` / `api` / `lib` / `features` / `hooks`）に限る。bootstrap と route ファイルへ業務判断を置かない | AGENTS.md の Issue 必須項目、backend-quick | パス分割は AI の実行計画。意味の受諾ではない |

## Decision → Acceptance Criteria / 決定 → 受け入れ条件

未回答のため AC は発行しない。回答後に、次の対応で AC-ID を切り、`*-SYS-*` / `*-FE-*` と 4 点セットへつなぐ。

| Q-ID / decision | AC-ID | Preconditions/action/observable result / 前提・操作・結果 | SYS / FE-ID or method | docs |
|---|---|---|---|---|
| Q1–Q8 unanswered | — | 発行しない。推奨を AC にしない | — | flow / ui / validation / db は予約について未作成のまま |

回答後に最低限ここへ戻す観測（文言は回答で置き換える）:

- Q2: 同一資源の交差する確定は 2 件目が拒否される。終端同士が接する確定は両方残る。同時送信は 1 件だけ成功する。
- Q3 Q4: 営業時間外・休業日・所要時間がはみ出す開始は候補に出ない。候補 0 件は成功した空結果である。
- Q5 Q6: 許可されていない主体の確定またはキャンセルは拒否される。許可されたキャンセルのあと、その区間が未来の営業時間内なら再び候補に出る。キャンセル済みは確定へ戻らない。
- Q7: 未来の確定予約と衝突する休業・短縮・無効化は保存されない（A の場合）。幅を広げる変更は既存予約の所要時間を変えない。
- Q8: A なら外部送信が無いことを理由付き N/A にする。B なら送信対象が「送信時刻に確定のままの予約」に限ることと、送信失敗が予約を変えないこと。

## Unresolved / Deferred — 未決 / Defer

| Item / 項目 | blocker / defer | Reason + stopped scope / 理由・停止範囲 | Resume condition / follow-up Issue |
|---|---|---|---|
| Q1 | blocker | 店舗の数と運営者の可視範囲が未決。予約の書き込み全体を止める | Q1 の回答 |
| Q2 | blocker | 占有資源と指名なしの意味が未決。空きと確定を止める | Q2 の回答。Q5 が A 以外なら同一人物ルールを follow-up |
| Q3 | blocker | 候補時刻の生成方法が未決 | Q3 の回答 |
| Q4 | blocker | 営業時間の形が未決 | Q4 の回答 |
| Q5 | blocker | 施術を受ける人と、店舗が予約を作れるかが未決 | Q5 の回答。B または C なら同一人物の重なりを follow-up |
| Q6 | blocker | キャンセル権限・期限・終端が未決 | Q6 の回答 |
| Q7 | blocker | 台帳変更の時間方向が未決。メニュー・スタッフ・営業・休業の更新を止める | Q7 の回答 |
| Q8 | blocker（通知のみ） | 経路と risk acceptance が未決。予約本体は Q8 が A でも Q1–Q7 を待つ | Q8 の回答 |
| 複数メニュー、スタッフとメニューの担当表、準備時間、スタッフ個人のログイン、電話番号 | defer | 依頼に無く、カテゴリ慣習として取り込まない。Assumption として記録済みであり Accepted ではない | 人間がそれらを要求したとき follow-up Question |
| 教材タスク CRUD の未コミット削除 | defer（実行上の前提） | 作業ツリーから教材が消えている。HEAD には残っている。どちらも予約の契約ではない。`make greenfield CONFIRM=1` は未実施であり、この調査では実行しない | 実装 Issue の前に、作業ツリーを製品の起点にするかの確認。予約の Q の回答とは独立 |
| concept / ADR / flow 4 点セット | defer | 意味が未受諾のまま concept や ADR を Accepted にしない。現行実装も無いので flow を現行契約として書かない | human-authority blocker が 0 件になった Prompt 2 のあと |

## Issue split / completion make — Issue 分割案 / 完了 make

Ready ではない。実装 Issue は作らない。

回答が揃い、再調査で新しい human-authority blocker が 0 件になってから、AI が次の順で Issue を切る。

1. 受諾した目的と用語を concept に、Q2 Q3 Q7 の採用理由を ADR に書く。Policy は反復する適用基準ができたときだけ作る。
2. `RESERVE_STORE`: 運営者の認証、Q1 の店舗境界、メニュー、スタッフ台帳、Q4 の営業時間と休業日、Q7 の保存拒否。
3. `RESERVE_CUSTOMER`: 利用者の登録とログイン、Q3 の空き、Q2 の確定、自分の予約一覧、Q6 のキャンセル。
4. Q8 が B または C のときだけ通知。A なら通知 Issue は作らず、後続必須として Questions に残す。

禁止: 決済。Q8 が A のあいだの外部送信。Controller / `bootstrap/` / route 定義への業務判断。許可パス外の教材タスクへの予約機能の追記。

完了コマンド（実装 Issue ができたとき）: ルートの `make lint`、`cd apps/backend && make test`、`cd apps/frontend && make test`、構造変更に伴い `make survey`。この Questions の作成時点では予約実装が無いので、これらのコマンドは実行していない。
