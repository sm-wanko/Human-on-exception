# Task CRUD — 意思決定と実行の例

**Status**: Example（既存実装から再構成した教材。実際の人間回答・Ready 承認を捏造しない）
**Pack / Flow**: `task-crud` / `TASK_CRUD`
**調査 revision**: `4d6c691c4702285323b5c494a3193ff19416882a`
**関連**: [Pack](../../ai/packs/task-crud.md) · [Flow](../../flow/タスクCRUD.md) · [Issue 例](../examples/task-crud-issue.md)

## Goal / Scope

最小のタスク管理を通して、AI が要件定義から検証まで自律実行できることを示す。
対象は一覧・詳細 UI と CRUD API。認証・会員監査・削除履歴・復元・mutation UI は対象外。認証なしの教材を公開サービスの認可設計として転用しない。

## 現状の事実

| 事実 | 根拠 |
|---|---|
| Controller → Service → Repository / DTO | Pack の Backend マニフェスト |
| 一覧と詳細のデータを分離 | `apps/backend/app/DTO/Task/TaskQuick.php` / `TaskDetail.php` |
| title / description の入力制約 | `apps/backend/app/Http/Requests/TaskWriteRequest.php` |
| 正系・逆系の縦串 | `apps/backend/tests/System/TaskCrudSystemTest.php` |
| loading / empty / error / detail path | `apps/frontend/src/lib/task/taskCrudFlow.contract.test.ts` |

## 人間に提示する Questions の例

### D1 — 削除したタスクを復元できる必要がある？

- 背景: 削除 API はデータを消す。保存方式の選択より先に、利用者が復元できる約束を決める必要がある。
- A: 復元しない。機能は小さいが、削除後に元へ戻せない。
- B: 復元できる。誤操作から戻せるが、保存期間・復元画面も範囲に入る。
- この教材の推奨: A。最小 CRUD が目的のため。
- 未回答なら削除仕様の変更を止める。実データ破壊の許可としては扱わない。

### U1 — タスクの登録・編集・削除画面も今回作る？

- A: API のみ。画面は一覧・詳細まで。一般利用者は画面で登録・編集できない。
- B: mutation UI まで作る。利用者が画面で管理できるが、入力・完了・戻り先の設計が増える。
- この教材の推奨: A。最小の縦串を示す目的に合う。
- 未回答なら mutation UI の追加を止める。

### A1 — この教材にログインと利用者ごとの所有権を含める？

- A: 含めない。教材として限定し、会員向け公開サービスの完成例にはしない。
- B: 含める。誰がどのタスクを操作できるか・監査まで別の契約を決める。
- この教材の推奨: A。認証を作った扱いにはしない。
- 未回答なら認証・権限に関する範囲拡張を止める。

## Answers の教材例

| Q-ID | 教材で採用する回答 | 理由 | 出所 |
|---|---|---|---|
| D1 | A | 最小 CRUD、復元なし | 既存サンプル仕様。実ユーザー回答ではない |
| U1 | A | list/detail + API CRUD に限定 | 同上 |
| A1 | A | 認証・会員監査は N/A | 同上 |

本例を新しい依頼に適用するときは実際の目的と回答を取得する。推奨を自動採用しない。

## AI が調査・規約で決める事項

| 項目 | 決定・根拠 |
|---|---|
| Quick / Detail | 既存 DTO と backend-quick の query 責務に従う |
| title・description・404 | 新しい要求がなければ既存 validation 契約を維持する |
| レイヤ配置 | BE / FE quick rules に従う |
| SIT / FE / 4 点セット | 必須 rules に従う。省略するかを質問しない |
| Issue 分割 | AI が依存に応じて決める。人間に作業管理をさせない |

## Risks / Unknowns / Assumptions と検討観点

| 観点 | 本例での扱い |
|---|---|
| 意図・境界 | D1 / U1 / A1。復元・mutation UI・認証は対象外 |
| 概念・意味 | [概念](../../concept/task-crud.md)。IDが同じTaskを一覧/詳細で示す。空と失敗を区別し、削除は完了状態と混同しない。専用の反復運用Policyは不要 |
| 入力・一意性 | validation 境界・not found を SYS で確認。業務重複キーなし |
| 作成・更新 | CRUD 正系と不正入力時の副作用を既存 test / flow で確認 |
| UX continuity | list→detail の ID、loading / empty / error を FE-ID に対応 |
| 障害 | API error を empty と区別。外部 API・有償境界は N/A（未使用） |
| 証拠・安全 | hard delete は復元不可。既存サンプルの合意例と実データ操作許可を区別 |
| 横断 | 一覧/詳細 DTO、BE/FE、4 点セットの整合 |
| 検証 | 下記対応表。ID の存在は実行成功の証拠ではない |

新規依頼の Unknowns / Assumptions は別途調査する。本例には実在する未回答の質問はない。

## 決定 → AC → 検証

| 決定 | AC-ID | 結果 | 検証 |
|---|---|---|---|
| CRUD 範囲 | AC-01 | 作成・取得・更新・削除が既存契約どおり | `TASK_CRUD-SYS-001`〜`004` |
| 既存入力契約 | AC-02 | 不正入力 / 不存在の応答と副作用が契約どおり | `TASK_CRUD-SYS-101`〜`102` |
| U1 | AC-03 | loading / empty / error を区別する | `TASK_CRUD-FE-001`〜`003` |
| U1 | AC-04 | 一覧から選択 ID の詳細へ進む | `TASK_CRUD-FE-004` + 代表 integration |
| D1 / A1 | AC-05 | 復元・認証・会員監査を完成扱いしない | 4 点セットの Scope / N/A 照合 |

docs は [flow](../../flow/タスクCRUD.md) / [ui](../../ui/タスクCRUD.md) / [validation](../../validation/タスクCRUD.md) / [db](../../db/タスクCRUD.md)。

## Issue / 完了 make

[教材用 Issue 本文](../examples/task-crud-issue.md) へ対応を引き継ぐ。実際の起票番号・実行結果は存在するときだけ記録する。

`make lint` → `make test` → `make survey`
