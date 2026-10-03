# Owned Task login — Questions

> Bilingual human-facing decision sheet. English and Japanese preserve the same decision-relevant meaning. See [language-policy](../../rules/language-policy.md).

**Status / 状態**: Ready / 回答済み。実装 blocker 0。親 [#3](https://github.com/sm-wanko/Human-on-exception/issues/3)、ログイン [#4](https://github.com/sm-wanko/Human-on-exception/issues/4)、本人の Task [#5](https://github.com/sm-wanko/Human-on-exception/issues/5)  
**Pack / Flow ID**: proposed / 提案 `auth`（新規）+ 現行 `task-crud` / `TASK_CRUD` の契約変更。未起票  
**Investigation revision / 調査 revision**: `e4132fcc11f342a823f1a042ab11850f648e7593`  
**Related / 関連**: [concept Task](../../concept/task-crud.md) · [Flow](../../flow/タスクCRUD.md) · [UI](../../ui/タスクCRUD.md) · [Validation](../../validation/タスクCRUD.md) · [DB](../../db/タスクCRUD.md) · [audit](../../rules/audit-ui-persistence.md)

依頼の原意: メールアドレスとパスワードでログインし、ログイン中の人の名前を表示する。その人が自分の Task を登録・閲覧・編集できる。項目は登録日・終了予定日・STATUS・内容・詳細。チェックは論理削除。他の人のものは閲覧・編集できない。

This sheet does not accept that request as a finished contract. Recommendations below are not answers.

## Goal / Scope

- Problem / success condition — 解決したい問題・成功条件: ログインした本人だけが、自分の Task を画面から登録・閲覧・編集でき、画面に本人の名前が出る。
- Scope 候補 — 今回の候補: アカウントの入口、ログイン中の名前表示、本人の Task の登録画面と編集、登録日・終了予定日・STATUS・内容・詳細、チェックによる論理削除、未ログインと他人の Task の拒否。
- Non-goals 候補 — 今回はやらない案: パスワード再設定メール、メール到達確認、OAuth、複数人での共有、管理者が他人の Task を操作すること、チェックした行の復元画面（Q2 で復元を選ばない限り）。
- Contracts to preserve — 維持する契約: 内容と詳細を既存の title / description に対応付ける場合、文字数制約（title は trim 後 1〜200、description は空可・最大 2000）は維持する。空一覧と取得失敗は別の表示のまま。教材 Task の「削除＝完了ではない」は、Q2 の回答で置き換わるまで現契約。

## Current facts / 現状の事実

| Fact / 事実 | Evidence path, symbol, revision / 根拠 | Affected route / 影響経路 |
|---|---|---|
| 利用者テーブルもログイン API もない。認証ミドルウェアは空 | `apps/backend/routes/api.php`、`apps/backend/bootstrap/app.php` の `withMiddleware`、`composer.json` に認証パッケージなし。revision `e4132fc` | 全 API |
| Task の書き込みは常に許可される | `TaskWriteRequest::authorize()` が `true` | POST/PATCH `/api/tasks` |
| 一覧は全員分の id と title。持ち主カラムはない | `tasks` マイグレーション `2026_09_22_000001_create_tasks_table.php`、`TaskRepository::listQuick()` | GET `/api/tasks`、画面 `/tasks` |
| 保存項目は title・description・作成時刻・更新時刻だけ | 同上マイグレーション。detail は `TaskRepository::findDetail()` | GET `/api/tasks/{id}` |
| 削除は行の物理削除。復元も論理削除もない | `TaskRepository::delete()` が `delete()`。concept は削除を完了やアーカイブと区別 | DELETE `/api/tasks/{id}` |
| 画面は一覧と詳細の閲覧だけ。登録・編集画面はない | `docs/ui/タスクCRUD.md` Scope。`apps/frontend/src/app/tasks/page.tsx` | `/tasks`、`/tasks/[id]` |
| 認証済み会員の監査カラムは、この Flow では N/A | `docs/db/タスクCRUD.md` 監査、`docs/rules/audit-ui-persistence.md` の Sample TASK_CRUD | 会員 mutation を足した時点で対象が変わる |
| concept / ADR / Policy に「アカウント」も「完了」もない。ADR と Policy の本文は索引のみ | `docs/concept/task-crud.md`、`docs/testing/adr/README.md`、`docs/testing/policy/README.md` | 意味の決定はこの Questions |

## Risks / Unknowns / Assumptions

| Kind / 区分 | Detail + impact / 内容・影響 | Evidence / 根拠 | Owner / 対応・判断者 |
|---|---|---|---|
| Unknown | ログインに使うアカウントと、画面に出す名前が、どこで作られるか未決。メールアドレス自体を名前にすると、依頼の「名前」と別物になる | users 不在 | Q1 |
| Unknown | STATUS、チェック、論理削除は依頼文では併記。現行 concept では削除は完了でもアーカイブでもない | concept の delete 行 | Q2 |
| Unknown | 登録日が、システムの作成時刻か、人が打ち込む日付か未決 | `created_at` のみ | Q3 |
| Unknown | 内容・詳細が、既存の title・description か、別項目か未決 | validation の title / description | Q4 |
| Risk | 持ち主の無い既存行を消すのはデータの消去。未ログイン公開 API を残すと「本人だけ」と衝突する | マイグレーションに owner なし。ルートは公開 | Q5 |
| Assumption | 共有・メール送信・OAuth は依頼に無いので Non-goals 候補。回答で覆せる | 依頼文 | 人間が Scope を確定するまで仮置き |

## Investigation dimensions / 検討観点

| Dimension | Result |
|---|---|
| Intent / boundary | Q1–Q5。共有とメール送信は Non-goals 候補 |
| Concepts / meaning | Task は ID で区別する 1 件のまま。チェックと STATUS と削除の意味は Q2。事実と候補の昇格は無し |
| Actors | 認証主体・操作主体・持ち主は、ログインした同一人物にする案。体験の記録主体もその人の Task。検索判断主体は今回の依頼に無い（N/A）。ログイン構造だけでは正式決定できないので Q1 と Q5 |
| Unit separation | 1 Task = 1 行は維持候補。一括チェックは依頼に無い（N/A）。登録日と `created_at` の一致は Q3。STATUS と論理削除フラグの一致は Q2 |
| Input / uniqueness | メールアドレスの重複拒否は、Q1 で自分登録を選んだ場合の同一人物の再登録防止。パスワードのハッシュ保存は技術判断。文字数は既存契約を維持する案 |
| Create / update | 登録画面と編集は依頼に含まれる。論理削除に変えると現行 DELETE の物理削除契約が変わる（Q2） |
| UX continuity | 名前はログイン後の一覧・詳細から見える必要がある。ログアウトが無いと表示中の人を交代できないため、名前の近くにログアウトを置くのは技術判断候補 |
| Failure | 空一覧と取得失敗は現行どおり分ける。未ログインと他人の Task は Q5 |
| Evidence / safety | 会員向け書き込みが発生した時点で監査ルールが適用される。これは人間への質問にしない。メール送信は非対象候補 |
| Cross-cutting | 現行 `TASK_CRUD` の「認証 N/A」と公開一覧は、この変更で契約が変わる。対になる公開参照機能は無い |
| Verification | 回答後に SYS / FE-ID を Issue へ割り当てる。認証 N/A のままにはしない |

## Questions

### Q1 — アカウントと、表示する名前 / Account and displayed name

**English**

- Background / concrete example: There is no user record. Email `a@example.com` can log in only after some account exists. The screen must show a name. Showing `a@example.com` does not match the request for a name. Example: Hanako registers, logs in, and the task screen shows 花子.
- Why human authority is required: Who is allowed to become a user, and which string is that person's name, defines the product. The repository has no account concept.
- A: The person creates the account on a registration screen with email, password, and display name, then logs in. The shown name is that display name. A second registration with the same email is rejected.
- B: There is no registration screen. Accounts, including the display name, are prepared outside this scope. This scope is login and name display only.
- Recommendation + reason: A. Nothing in the repository can prepare accounts, and the request asks for the person's name rather than the email address.
- What remains blocked without an answer: login, name display, and any rule that attaches a task to a person.

**日本語**

- 背景・具体例: 利用者の記録がない。`a@example.com` でログインするには、先にアカウントが要る。画面に名前を出す依頼であり、メールアドレスの表示とは別。例: 花子さんがメール・パスワード・表示名で登録し、ログイン後の Task 画面に「花子」と出る。
- なぜ人間判断が必要か: 誰が利用者になれるかと、名前として扱う文字列はプロダクトの意味。リポジトリにアカウント概念がない。
- A: 登録画面でメールアドレス、パスワード、表示名を本人が作り、その後ログインする。表示するのは表示名。同じメールアドレスの再登録は拒否する。
- B: 登録画面は作らない。表示名を含むアカウントは、この範囲の外で用意する。この範囲はログインと名前表示だけ。
- 推奨と理由: A。アカウントを用意する仕組みがリポジトリに無く、依頼はメールアドレスではなく名前の表示。
- 未回答で止まる範囲: ログイン、名前表示、Task を人に結びつける規則。

### Q2 — チェック、STATUS、論理削除 / Checkbox, STATUS, and logical delete

**English**

- Background / concrete example: The request names STATUS, a checkbox, and logical delete together. Today, delete erases the row and concept says that erasure is neither completion nor archive. Example task "牛乳を買う": checking it could mean done, or hidden, or both.
- Why human authority is required: Treating check, status, and delete as the same concept changes what the user is promised. The current concept keeps them apart.
- A: STATUS and the checkbox are different. The person sets STATUS separately. The checkbox only logically deletes: the row stays stored, leaves the normal list and detail, and this scope has no screen to bring it back. The current physical DELETE stops.
- B: The checkbox is completion, stored as STATUS. The task stays visible as completed. There is no logical delete.
- C: The checkbox both marks completion and hides the task by logical delete. There is no extra STATUS set. Checking is the only state change, and unchecked rows are the active ones.
- If A is chosen, name the STATUS labels in the answer. A usable starting set is 未着手 / 進行中 / 完了, and the answer may replace those words.
- If logical delete is chosen (A or a hide behavior), also say whether a later screen may list checked rows and uncheck them. Default recommendation inside A is: no restore screen in this scope.
- Recommendation + reason: A, with no restore screen. The request states STATUS and checkbox logical-delete as separate phrases. B and C collapse them.
- What remains blocked without an answer: task fields, the checkbox, and any change to delete.

**日本語**

- 背景・具体例: 依頼は STATUS、チェック、論理削除を並べている。現行の削除は行を消し、concept はその消去を完了やアーカイブと分けている。例: 「牛乳を買う」をチェックしたとき、完了なのか、見えなくなるだけなのか、両方なのかが分かれる。
- なぜ人間判断が必要か: チェックと状態と削除を同じ意味にすると、利用者への約束が変わる。現行概念はこれらを分けている。
- A: STATUS とチェックは別。STATUS は人が別に選ぶ。チェックは論理削除だけで、行は残るが通常の一覧と詳細から外れ、この範囲に戻す画面は無い。現行の物理 DELETE はやめる。
- B: チェックは完了であり、それが STATUS になる。完了として一覧に残る。論理削除はしない。
- C: チェックは完了かつ論理削除で隠す。STATUS の別集合は持たない。チェックが唯一の状態変化で、未チェックが通常の Task。
- A を選ぶときは、STATUS のラベルを回答に書く。起点の例は 未着手 / 進行中 / 完了。この語を回答で置き換えてよい。
- 論理削除を選ぶ場合は、あとからチェック済みを一覧して外せるかも回答する。A の中での推奨は、この範囲に復元画面を作らない。
- 推奨と理由: A、復元画面なし。依頼文が STATUS と、チェックによる論理削除を分けて書いており、B と C はそれを一つにまとめる。
- 未回答で止まる範囲: Task の項目、チェック、削除の変更。

### Q3 — 登録日と終了予定日 / Registration date and due date

**English**

- Background / concrete example: The database already stores a system timestamp when the row is created. The screen does not present it as a registration date. A due date does not exist. Example: created on 2026-09-25 at 09:40, due 2026-09-30. Whether the person can type 2026-09-01 as the registration date is undecided.
- Why human authority is required: A typed registration date and a system timestamp are different facts. A due date that changes STATUS by itself creates another concept.
- A: The registration date is the system time the task is created. The person does not type it. The screen shows that date. The due date is an optional date the person enters. Passing that date does not change STATUS and does not create an overdue status.
- B: The registration date is a date the person enters, stored in addition to the system timestamp. The due date stays optional and does not change STATUS.
- C: Same stored dates as A, and passing the due date automatically changes STATUS or adds a distinct overdue state.
- Recommendation + reason: A. 「登録日」 matches the moment the record is created, and the request does not ask the date to drive STATUS.
- What remains blocked without an answer: which dates exist, whether they are editable, and whether time passing changes task meaning.

**日本語**

- 背景・具体例: 行を作ったシステムの時刻は既にある。画面はそれを登録日としては出していない。終了予定日は無い。例: 作成が 2026-09-25 09:40、終了予定が 2026-09-30。登録日を 2026-09-01 と手入力できるかは未決。
- なぜ人間判断が必要か: 手入力の登録日と、システムの作成時刻は別の事実。終了予定日が STATUS を自分で変えるなら、それも別概念。
- A: 登録日は Task 作成時のシステム時刻。人は入力しない。画面にはその日付を出す。終了予定日は人が入れる任意の日付。その日を過ぎても STATUS は変わらず、延滞という状態も作らない。
- B: 登録日は人が入れる日付で、システムの作成時刻とは別に保存する。終了予定日は任意のままで、STATUS は変えない。
- C: 保存する日付は A と同じで、終了予定日を過ぎると STATUS が自動で変わるか、延滞という別状態が付く。
- 推奨と理由: A。「登録日」は記録ができた時点と一致し、依頼は日付が STATUS を動かすと書いていない。
- 未回答で止まる範囲: どの日付を持つか、編集できるか、時間経過で Task の意味が変わるか。

### Q4 — 内容・詳細と既存項目 / Body text and existing fields

**English**

- Background / concrete example: A task today has a required short title and an optional longer description. The request says 内容 and 詳細. Example: 内容「牛乳を買う」, 詳細「近所の店で低脂肪」.
- Why human authority is required: Adding a third text field, or renaming the user's words onto the existing fields, decides what one task contains.
- A: 内容 is the existing title, required, 1 to 200 characters after trim. 詳細 is the existing description, optional, at most 2000 characters. No extra text field.
- B: 内容 and 詳細 are new fields in addition to the existing title and description.
- Recommendation + reason: A. The request describes two text parts, which matches the two fields already stored.
- What remains blocked without an answer: the task form and the write contract.

**日本語**

- 背景・具体例: 現行の Task は、必須の短い title と、空でもよい長い description。依頼の語は内容と詳細。例: 内容「牛乳を買う」、詳細「近所の店で低脂肪」。
- なぜ人間判断が必要か: 文章項目を増やすか、依頼の語を既存の2項目に対応付けるかは、1件の中身の定義。
- A: 内容は既存の title。必須、前後空白を除いて 1〜200 文字。詳細は既存の description。空可、最大 2000 文字。文章項目は増やさない。
- B: 内容と詳細は、既存の title・description に加える新しい項目。
- 推奨と理由: A。依頼の文章は2つで、既に保存している項目数と一致する。
- 未回答で止まる範囲: 登録・編集フォームと、書き込み契約。

### Q5 — 本人だけ見える、と既存データの行き先 / Owner-only access and existing rows

**English**

- Background / concrete example: Every task is readable and writable without login, and no row has an owner. After this change, Hanako must not see Taro's task. The sample rows already in the database have nobody to belong to.
- Why human authority is required: Closing the public API changes the current contract. Deleting ownerless rows is destructive. Showing 403 instead of 404 tells a caller that the other person's task exists.
- A: Every task read and write requires login. New tasks belong to the logged-in person. Lists and details show only that person's tasks. Another person's id and an unknown id both respond as not found (404). Existing ownerless rows stay stored and are shown to nobody. Do not delete them in this change.
- B: Same access rule as A, and this change deletes the existing ownerless rows.
- C: Another person's existing id responds 403, so the caller can tell that some task exists. Ownerless rows stay hidden, as in A.
- Recommendation + reason: A. The request limits viewing and editing to the owner. 404 keeps existence private. Deleting current rows was not requested and cannot be undone.
- What remains blocked without an answer: authorization, list contents, and migration of current tasks.

**日本語**

- 背景・具体例: いまの Task はログインなしで閲覧・変更でき、行に持ち主がいない。変更後は花子さんが太郎さんの Task を見ない。データベースに既にある教材の行は、帰属先がいない。
- なぜ人間判断が必要か: 公開 API を閉じるのは現行契約の変更。持ち主の無い行を消すのはデータの消去。403 は、他人の Task が存在すると呼び出し側に知らせる。
- A: Task の閲覧と書き込みはすべてログイン必須。新しい Task はログイン中の人のもの。一覧と詳細はその人の Task だけ。他人の id と、存在しない id はどちらも見つからない（404）。持ち主の無い既存行は残し、誰の画面にも出さない。この変更では消さない。
- B: 見える範囲は A と同じ。あわせて、持ち主の無い既存行をこの変更で削除する。
- C: 見える範囲は A と同じで、他人の id には 403 を返す。存在することは呼び出し側に分かる。持ち主の無い行は A と同様に隠す。
- 推奨と理由: A。依頼は閲覧と編集を本人に限る。404 なら存在を知らせない。既存行の削除は依頼に無く、戻せない。
- 未回答で止まる範囲: 認可、一覧の中身、既存 Task の移行。

## Answers / Decision history — 回答・決定履歴

最初の回答。置換前の回答は無い。

| Q-ID | Answer | Reason / 理由 | Source + date/reference / 回答元 | Status / 置換先 |
|---|---|---|---|---|
| Q1 | A | 推奨を採用。表示名はメールアドレスではない。同じメールの再登録は拒否 | 依頼者、2026-09-25、「全部推奨で良い」 | Accepted |
| Q2 | A。STATUS は 未着手 / 進行中 / 完了。復元画面は作らない | 推奨を採用。STATUS と論理削除を分けたままにする | 同上 | Accepted |
| Q3 | A | 推奨を採用。登録日は作成時刻。終了予定日は任意で、STATUS を変えない | 同上 | Accepted |
| Q4 | A | 推奨を採用。内容は title、詳細は description。文章項目は増やさない | 同上 | Accepted |
| Q5 | A | 推奨を採用。他人の id も未知の id も 404。持ち主の無い行は残して誰にも見せない | 同上 | Accepted |

同じ回答で、提示していた Non-goals もこの範囲の外にした。共有、パスワード再設定メール、メール到達確認、OAuth、管理者による他人の Task の操作、この範囲での復元。

Do not copy the recommendation into Answer. Do not silently overwrite a previous answer.  
推奨を Answer に代入しない。改訂前の回答を黙って上書きしない。

## AI technical decisions / AI の技術判断

これらは回答ではない。人間の回答と衝突しない範囲での実装候補。

| Item / 項目 | Decision / 判断 | Rule/code evidence / 根拠 | Why no human decision is required / 人間判断不要の理由 |
|---|---|---|---|
| ブラウザのログイン維持 | ブラウザ向けのログインセッション。別モバイルクライアントは依頼に無い | 現行 UI は Next.js の画面。API トークン利用者は無い | ログイン後に名前が見える、という約束は変えない |
| ログアウト | 表示中の名前の近くにログアウトを置く | Q1 の名前表示は、人を交代できないと固定される | 依頼された表示を成立させる操作 |
| パスワード | ハッシュで保存する。最小長などの具体値は実装時に既存の枠で決める | 平文保存は依頼のパスワード入口と両立しない | 誰がログインできるかの意味は変えない |
| 監査 | ログイン後の会員向け作成・更新・論理削除には、監査ルールの `created_by` 等を適用する | `docs/rules/audit-ui-persistence.md`。現行 N/A は認証が Scope 外だから | 規則が既に決めており、質問にしない |
| 層の配置 | 認証と Task は所有ごとに Controller / Service / Repository と frontend の lib を分ける | backend-quick / frontend-quick | 実装配置 |
| 外部メール | 送らない | system-test-strategy の実メール境界。回答で Non-goals 確定 | 意味は変えない |
| 新規 Task の STATUS | 作成直後は 未着手。空の STATUS は第4の状態になるため作らない | Q2 で採用したラベル | 合意した語彙の初期値 |
| STATUS の保存 | 表示ラベルは合意の日本語。内部値は別コードにしてよい | 画面の語を変える決定は人間 | 表示の意味は変えない |
| ログイン失敗 | メールアドレスの有無を知らせない。未知のメールもパスワード誤りも同じ失敗 | Q1 の本人確認 | 誰が登録済みかの情報を足さない |
| メールアドレスの同一性 | 前後空白を除き、大文字小文字を区別しない | Q1 の「同じメールアドレス」 | 別人が同じメールを持つ意味にはしない |
| パスワードの最小長 | 8 文字以上。短い入力は拒否。ハッシュ保存 | 以前の「実装時に決める」技術判断 | 誰が登録できるかの概念は変えない |

## Decision → Acceptance Criteria / 決定 → 受け入れ条件

| Q-ID / decision | AC-ID | Preconditions/action/observable result / 前提・操作・結果 | SYS / FE-ID or method | docs |
|---|---|---|---|---|
| Q1 | AC-01 | 表示名つきで登録し、ログイン後にその表示名が見える。ログアウト後は名前が出ない | `AUTH_LOGIN-SYS-001` `AUTH_LOGIN-SYS-004` `AUTH_LOGIN-FE-001` `AUTH_LOGIN-FE-002` | auth の 4点セットを新設 |
| Q1 | AC-02 | 同じメールアドレスの再登録は拒否され、アカウントは1件のまま | `AUTH_LOGIN-SYS-002` | auth validation |
| Q1 | AC-03 | 未知のメールと誤ったパスワードは同じ失敗。ログイン状態にならない | `AUTH_LOGIN-SYS-003` | auth validation |
| Q2 | AC-04 | 作成直後の STATUS は 未着手。人が 進行中 / 完了 に変えられる。チェックしても STATUS は変わらない | `TASK_CRUD-SYS-008` `TASK_CRUD-FE-006` | flow / ui / validation / db |
| Q2 | AC-05 | チェックで行は残り、本人の通常一覧と詳細から外れる。物理削除はしない。復元画面は無い | `TASK_CRUD-SYS-009` `TASK_CRUD-FE-007`。現行 `TASK_CRUD-SYS-004` の hard delete 期待は回答後の契約へ更新 | db |
| Q3 | AC-06 | 登録日は作成時刻で入力できない。終了予定日は空でもよく、過去でも STATUS は変わらない | `TASK_CRUD-SYS-008` | ui / validation |
| Q4 | AC-07 | 内容は必須 1〜200。詳細は空可、最大 2000。第3の文章項目は無い | 現行 `TASK_CRUD-SYS-001` `TASK_CRUD-SYS-101` を認証付きの期待へ更新 | validation |
| Q5 | AC-08 | 未ログインの Task 閲覧・作成・更新・論理削除は拒否され、書き込みが無い | `TASK_CRUD-SYS-005` | flow の認証 N/A を更新 |
| Q5 | AC-09 | 他人の id と存在しない id はどちらも 404。本人の一覧には他人の Task と持ち主の無い既存行が出ない | `TASK_CRUD-SYS-006` `TASK_CRUD-SYS-007` `TASK_CRUD-FE-002` | flow / db |
| Q2 Q5 | AC-10 | 本人の作成・更新・論理削除は監査カラムに操作者を残す | `TASK_CRUD-SYS-010` | db |

## Unresolved / Deferred — 未決 / Defer

| Item / 項目 | blocker / defer | Reason + stopped scope / 理由・停止範囲 | Resume condition / follow-up Issue |
|---|---|---|---|
| 共有、パスワード再設定、メール確認、OAuth、管理者操作、復元画面 | defer | 回答済み Non-goals。この実装には入れない | 目的を変える新しい回答 |
| Policy | defer | 反復する個別精査基準は発生していない。空の Policy は作らない | 同じ判断を多数の項目へ適用するとき |

実装上の意味の blocker は 0。Q4 の用語は concept に置き、別 ADR は作っていない。

## Issue split / completion make — Issue 分割案 / 完了 make

同一 Scope のまま2つに分ける。親は統合用で、実装 Ready な作業は子だけ。

1. アカウント、ログイン、ログアウト、表示名。[#4](https://github.com/sm-wanko/Human-on-exception/issues/4)。Pack `auth`、Flow `AUTH_LOGIN`。依存なし。AC-01〜AC-03。
2. 本人の Task の登録・編集、STATUS、日付、チェックによる論理削除、認可。[#5](https://github.com/sm-wanko/Human-on-exception/issues/5)。Pack `task-crud`、Flow `TASK_CRUD`。#4 のアカウントに依存。AC-04〜AC-10。現行の認証 N/A と hard delete は回答後の契約へ更新する。

親は [#3](https://github.com/sm-wanko/Human-on-exception/issues/3)。親自身は実装しない。

完了はどちらも `make lint` → `make test` → `make survey`。作業ブランチは親の `feat/owned-task-login` から子を切り、PR の base はその親ブランチ。順序は 1 のあと 2。親の main への統合は子の検証後。

Policy は適用不要。途中で意味の blocker が出たときだけ Questions へ戻す。
