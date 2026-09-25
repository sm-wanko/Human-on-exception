# ADR-001 — Self-registered account / 本人登録のアカウント

**Status**: Accepted  
**Decision authority / 判断主体**: human requester, 2026-09-25, 「全部推奨で良い」 → Q1=A  
**Source / 根拠**: [owned-task-login](../questions/owned-task-login.md) Q1

## Context / 背景

ログインと表示名の依頼に対し、利用者の記録がリポジトリに無かった。メールアドレスを名前として見せる案と、登録画面を作らない案があった。

The login request needed an account and a display name. No user record existed. Alternatives were showing the email address as the name, or omitting the registration screen.

## Options / 選択肢

- A: The person registers email, password, and display name, then logs in. The screen shows the display name. The same email cannot register twice.
- B: No registration screen. Accounts are prepared outside this scope.

## Decision / 決定

A。表示名はメールアドレスとは別の項目。同じメールアドレスの再登録は拒否する。パスワード再設定メール、メール到達確認、OAuth はこの決定に含まない。

A. The display name is a separate field from the email address. A second registration with the same email is rejected. Password-reset mail, email verification, and OAuth are outside this decision.

## Reason / 理由

アカウントを用意する既存の仕組みが無く、依頼は名前の表示だった。B は表示名の出どころをこの範囲の外に残す。

No existing mechanism could prepare accounts, and the request asked for a name. B would leave the source of the display name outside this scope.

## Impact / 影響

ログイン、名前表示、Task の持ち主はこのアカウントに結び付く。見直し条件: 本人登録以外の発行主体を認めるとき。

Login, name display, and task ownership attach to this account. Revisit when an issuer other than the person is accepted.

## Related

[concept](../../concept/owned-task.md) · Questions Q1
