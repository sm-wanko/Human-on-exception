# ADR-002 — STATUS and logical delete / STATUS と論理削除

**Status**: Accepted  
**Decision authority / 判断主体**: human requester, 2026-09-25, 「全部推奨で良い」 → Q2=A  
**Source / 根拠**: [owned-task-login](../questions/owned-task-login.md) Q2

## Context / 背景

依頼は STATUS、チェック、論理削除を並べていた。現行の削除は行を物理的に消し、完了でもアーカイブでもない。

The request named STATUS, a checkbox, and logical delete together. Current delete erases the row and is neither completion nor archive.

## Options / 選択肢

- A: STATUS and the checkbox differ. The checkbox only logically deletes. No restore screen. Physical DELETE stops.
- B: The checkbox is completion and remains visible. No logical delete.
- C: The checkbox both completes and hides the task. No separate STATUS labels.

## Decision / 決定

A。STATUS は 未着手 / 進行中 / 完了。チェックは論理削除であり、行は残り、通常の一覧と詳細から外れる。この範囲に復元画面は無い。物理削除はやめる。チェックは STATUS を変えない。

A. STATUS labels are 未着手 / 進行中 / 完了. The checkbox logically deletes: the row remains and leaves the normal list and detail. This scope has no restore screen. Physical deletion stops. The checkbox does not change STATUS.

## Reason / 理由

依頼文が STATUS と論理削除を分けていた。B と C はその区別を一つにまとめる。

The request stated STATUS and logical delete as separate phrases. B and C collapse that distinction.

## Impact / 影響

現行の hard delete 契約は、この決定の実装時に置き換わる。見直し条件: 復元、またはチェックを完了と同一視する回答。

The current hard-delete contract is replaced when this decision is implemented. Revisit if restore is accepted, or if the checkbox is identified with completion.

## Related

[concept](../../concept/owned-task.md) · Questions Q2
