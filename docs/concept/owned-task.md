# Owned Task — Agreed concept / 本人の Task（合意した概念）

## English

Agreed purpose from [Questions](../testing/questions/owned-task-login.md) on 2026-09-25. The human accepted every recommendation. This is the target meaning. Current screens and API remain the teaching Task CRUD until the owning Issues land. Do not read the current code as this concept already being implemented.

A person keeps their own tasks private. They register with email, password, and a display name, then log in. The screen shows that display name, not the email address.

| Concept | Meaning | Do not confuse with |
|---|---|---|
| Account | one person, identified by one email address | the display name is not the email address |
| Display name | the name shown while that person is logged in | not a second person and not a login id |
| Task | one record distinguished by ID, owned by one account | another account's task, or a task with no owner |
| 内容 | the required short text (existing title) | 詳細 |
| 詳細 | the optional longer text (existing description) | a third text field |
| 登録日 | the system time the task row was created | a date the person types |
| 終了予定日 | an optional date the person enters | a trigger that changes STATUS, and not an overdue state |
| STATUS | a label the person sets: 未着手 / 進行中 / 完了 | the checkbox |
| Checkbox logical delete | the row stays stored and leaves the normal list and detail | completion, archive, or physical deletion. No restore screen in this scope |

Example: Hanako registers, logs in, and sees 花子. She creates 「牛乳を買う」 with a due date and STATUS 未着手. Taro does not see it. Checking the row hides it from Hanako's list and detail, and the row remains stored. A task with no owner stays stored and appears for nobody.

Counterexamples that remain outside this concept: a shared task, an administrator opening another person's task, logging in with only an email address and no display name, treating a past due date as an automatic status change, restoring a checked task in this scope.

Actor boundaries: the authentication actor, the operating actor, the owner, and the person whose task is recorded are the same logged-in account. There is no separate search or decision actor in this scope.

Design reasons: [ADR-001](../testing/adr/001-self-registered-account.md), [ADR-002](../testing/adr/002-task-status-and-logical-delete.md), [ADR-003](../testing/adr/003-task-dates.md), [ADR-004](../testing/adr/004-task-owner-isolation.md). No repeatable Policy yet. Procedures stay in the 4-point docs after implementation.

## 日本語

2026-09-25 の [Questions](../testing/questions/owned-task-login.md) で、推奨をすべて採用した合意。これは目標の意味であり、画面と API が教える現行の Task CRUD は、対応する Issue が実装されるまで置き換わらない。現行コードを、この概念の実装済みとは読まない。

一人の人が自分の Task を他の人から隠して持つのが目的。メールアドレス、パスワード、表示名で登録し、ログインする。画面に出るのは表示名であり、メールアドレスではない。

| 概念 | 意味 | 混同しないこと |
|---|---|---|
| アカウント | メールアドレス1つで識別する一人 | 表示名はメールアドレスではない |
| 表示名 | ログイン中に画面へ出す名前 | 別の人でもログイン ID でもない |
| Task | ID で区別する1件で、アカウント1つが持つ | 他のアカウントの Task、持ち主の無い Task |
| 内容 | 必須の短い文章（既存の title） | 詳細 |
| 詳細 | 任意の長い文章（既存の description） | 3つ目の文章項目 |
| 登録日 | 行が作られたシステムの時刻 | 人が入力する日付 |
| 終了予定日 | 人が入力する任意の日付 | STATUS を変えるきっかけ、延滞状態 |
| STATUS | 人が選ぶ 未着手 / 進行中 / 完了 | チェック |
| チェックによる論理削除 | 行は残り、通常の一覧と詳細から外れる | 完了、アーカイブ、物理削除。この範囲に復元画面は無い |

例: 花子さんが登録してログインすると「花子」と出る。「牛乳を買う」を終了予定日と STATUS 未着手で作る。太郎さんからは見えない。チェックすると花子さんの一覧と詳細から消え、行は保存されたまま残る。持ち主の無い Task は保存されたまま、誰の画面にも出ない。

この概念の外に残す反例: 共有する Task、管理者が他人の Task を開くこと、表示名なしでメールアドレスだけをログインにすること、終了予定日を過ぎたことを自動の状態変化とみなすこと、この範囲でチェック済みを復元すること。

主体: 認証する人、操作する人、持ち主、Task に記録される人は、ログインしている同一アカウント。この範囲に別の検索・判断主体は無い。

設計の理由: [ADR-001](../testing/adr/001-self-registered-account.md)、[ADR-002](../testing/adr/002-task-status-and-logical-delete.md)、[ADR-003](../testing/adr/003-task-dates.md)、[ADR-004](../testing/adr/004-task-owner-isolation.md)。反復適用する Policy はまだ無い。手順は実装後の4点セットに置く。

Language parity / 言語一致: [language-policy](../rules/language-policy.md).
