# Task CRUD — Issue 本文の教材例

**Status**: Example（未起票。新規機能の実装許可ではない）

## AI コンテキスト

| 項目 | 内容 |
|---|---|
| Pack | `task-crud` |
| Flow ID | `EXAMPLE_EXAMPLE_TASK_CRUD` |
| Questions / 決定 | [task-crud](../questions/task-crud.md) D1 / U1 / A1、revision `4d6c691c4702285323b5c494a3193ff19416882a` の教材 |
| 触ってよいパス | Pack 記載の Task BE/FE 実装・対応テスト、Task の flow/ui/validation/db、Pack 本文 |
| 禁止 | 認証・復元・mutation UI 追加、他ドメイン変更、Quick / Detail の無断統合 |
| 完了時 make | `make lint` → `make test` → `make survey` |

## Goal / 契約

一覧・詳細 UI と CRUD API を最小の縦串として提供する。既存の入力制約・DTO・HTTP 契約を維持し、削除後の復元と会員機能は対象外。

## 受け入れ条件

| 決定 | AC-ID | 前提・操作・結果 | 検証 |
|---|---|---|---|
| CRUD 範囲 | AC-01 | 有効入力で CRUD を実行し、応答・DB 状態が Flow と一致 | SYS-001〜004（接頭辞 `EXAMPLE_EXAMPLE_TASK_CRUD-`） |
| 既存 validation | AC-02 | 不正入力 / 不存在で契約どおりエラー、意図しない write なし | SYS-101〜102 |
| U1 | AC-03 | 一覧取得中・空・失敗が別状態で表示される | FE-001〜003 |
| U1 | AC-04 | 一覧選択の ID を詳細 URL へ渡す | FE-004 + 代表 integration |
| D1 / A1 | AC-05 | 復元・認証・会員監査を完成済みと記載しない | docs Scope / N/A |

## docs / 依存 / Risks

- 4 点セットと [Pack](../../ai/packs/task-crud.md) を同一変更系列で整合させる。
- BE 契約→FE 接続→統合検証の順。分割する場合は親と子の実在 Issue / PR を相互リンクする。
- hard delete は不可逆。教材の API 仕様例は本番データ削除の許可ではない。
- Evidence は実行後に PR へ command・結果・revision を記録する。チェック欄を埋めるだけで完了にしない。
