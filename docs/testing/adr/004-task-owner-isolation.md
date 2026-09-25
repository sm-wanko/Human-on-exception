# ADR-004 — Task owner isolation / Task の本人分離

**Status**: Accepted  
**Decision authority / 判断主体**: human requester, 2026-09-25, 「全部推奨で良い」 → Q5=A  
**Source / 根拠**: [owned-task-login](../questions/owned-task-login.md) Q5

## Context / 背景

Task はログインなしで閲覧・変更でき、行に持ち主がいない。公開を残すこと、他人の存在を 403 で知らせること、持ち主の無い行を削除することが選択肢だった。

Tasks are readable and writable without login, and rows have no owner. Alternatives were keeping public access, revealing another person's task with 403, or deleting ownerless rows.

## Options / 選択肢

- A: Login is required to read or write tasks. Callers cannot distinguish another person's id from an unknown id (404). Ownerless rows stay stored and are shown to nobody.
- B: Same access rule, and this change deletes ownerless rows.
- C: Another person's id returns 403.

## Decision / 決定

A。新しい Task の持ち主はログインしているアカウント。一覧と詳細はその人の、論理削除されていない Task だけ。持ち主の無い既存行はこの変更で削除しない。

A. A new task belongs to the logged-in account. Lists and details contain only that person's tasks that are not logically deleted. This change does not delete existing ownerless rows.

## Reason / 理由

閲覧と編集を本人に限る依頼と一致し、存在の通知と既存行の消去を避ける。

This matches the request to limit viewing and editing to the owner, without revealing existence or erasing existing rows.

## Impact / 影響

現行の認証 N/A と公開 API は、この決定の実装時に置き換わる。見直し条件: 共有、管理者による他者操作、または既存行の削除を認めるとき。

The current authentication N/A and public API are replaced when this decision is implemented. Revisit when sharing, administrative access, or deletion of existing rows is accepted.

## Related

[concept](../../concept/owned-task.md) · Questions Q5
