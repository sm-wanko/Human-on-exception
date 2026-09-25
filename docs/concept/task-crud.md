# Task CRUD Concept — Teaching Example / Task CRUD の概念（教材）

## English

This document explains the original sample before login. The accepted meaning for the current product change is [owned-task.md](./owned-task.md). It does **not** represent a new approval by itself.

Its purpose is to demonstrate a complete path for listing/viewing Tasks and creating/updating/deleting them through the API, with responsibilities mapped to tests and human-readable docs. Login, restore, and create/edit/delete screens are outside scope.

| Concept | Meaning in this sample | Do not confuse with |
|---|---|---|
| Task | one record distinguished by ID | same title does not imply same Task |
| Quick / Detail | read information needed for list vs detail | not two separate Tasks; same ID, different display purpose |
| empty list | retrieval succeeded and there are zero Tasks | loading/failure is not evidence of empty state |
| delete | remove the record with no restore feature | not completion state or archive |

Example: selecting ID=42 in the list navigates to the detail for ID=42. If retrieval fails, do not describe it as "no record exists" without the contract supporting that meaning.

Evidence: [TaskRepository](../../apps/backend/app/Repositories/Task/TaskRepository.php) / [FE contract](../../apps/frontend/src/lib/task/taskCrudFlow.contract.test.ts). For API/input/DB detail, enter through the [Pack](../ai/packs/task-crud.md) and follow the 4-point docs.

The decision-teaching material is [Questions](../testing/questions/task-crud.md) and [Issue example](../testing/examples/task-crud-issue.md). Never reinterpret the sample's delete behavior as authorization to destroy production data in another product.

## 日本語

ログイン前の元サンプルを説明する資料。現行の合意は [owned-task.md](./owned-task.md)。このファイル自体が新しい承認を表すものではない。

目的は、タスクの一覧・詳細を閲覧し、APIで登録・更新・削除する一連の処理を、責務・テスト・説明文書と対応づけて示すこと。ログイン、復元、登録・編集・削除の画面は範囲外。

| 概念 | この教材での意味 | 混同しないこと |
|---|---|---|
| Task | IDで区別する1件の記録 | 同じタイトルだから同一Taskとは限らない |
| Quick / Detail | 一覧と詳細に必要な読み取り情報 | 別々のTaskではなく同じIDの表示目的の違い |
| 空一覧 | 取得に成功し、Taskが0件 | 取得中・取得失敗は空一覧の証拠ではない |
| 削除 | 記録を削除し復元を提供しない | 完了状態への変更やアーカイブではない |

例: 一覧でID=42を選ぶと、そのIDの詳細へ進む。取得に失敗したときは、契約上の根拠なしに「記録がない」と説明しない。

根拠: [TaskRepository](../../apps/backend/app/Repositories/Task/TaskRepository.php) / [FE contract](../../apps/frontend/src/lib/task/taskCrudFlow.contract.test.ts)。API・入力・DBの詳細は [Pack](../ai/packs/task-crud.md) から4点セットへ。

判断の教材は [Questions](../testing/questions/task-crud.md) と [Issue例](../testing/examples/task-crud-issue.md)。教材の削除仕様を、本番データを破壊する許可に転用しない。

Language parity / 言語一致: [language-policy](../rules/language-policy.md).
