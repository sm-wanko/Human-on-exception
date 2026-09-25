# ADR-003 — Task dates / Task の日付

**Status**: Accepted  
**Decision authority / 判断主体**: human requester, 2026-09-25, 「全部推奨で良い」 → Q3=A  
**Source / 根拠**: [owned-task-login](../questions/owned-task-login.md) Q3

## Context / 背景

行の作成時刻はある。終了予定日は無く、登録日を手入力できるかは未決だった。日付が STATUS を動かす案もあった。

A system creation time exists. A due date does not. Whether the person types the registration date was undecided, as was letting that date drive STATUS.

## Options / 選択肢

- A: Registration date is the system creation time and is not typed. Due date is optional. Passing it does not change STATUS and creates no overdue state.
- B: Registration date is a date the person enters, separate from the system timestamp.
- C: Passing the due date changes STATUS or adds an overdue state.

## Decision / 決定

A。終了予定日を過ぎても Task の STATUS は変わらない。延滞という状態は持たない。

A. A past due date does not change STATUS. There is no overdue state.

## Reason / 理由

登録日は記録ができた時点であり、依頼は日付による自動の意味変化を求めていなかった。

The registration date matches when the record was created. The request did not ask the date to change meaning automatically.

## Impact / 影響

登録日は作成時刻の表示。終了予定日は人が編集できる任意項目。見直し条件: 過去日の手入力、または日付による状態変化を認めるとき。

The registration date is the displayed creation time. The due date is an optional editable field. Revisit when backdating or a date-driven state change is accepted.

## Related

[concept](../../concept/owned-task.md) · Questions Q3
