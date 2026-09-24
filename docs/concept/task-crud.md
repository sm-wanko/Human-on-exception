# Task CRUD の概念（教材）

既存の最小実装を説明する資料。実際の新規プロダクトに対する人間の回答・承認を表すものではない。

目的は、タスクの一覧・詳細を閲覧し、APIで登録・更新・削除する一連の処理を、責務・テスト・説明文書と対応づけて示すこと。ログイン、復元、登録・編集・削除の画面は範囲外。

| 概念 | この教材での意味 | 混同しないこと |
|---|---|---|
| Task | IDで区別する1件の記録 | 同じタイトルだから同一Taskとは限らない |
| Quick / Detail | 一覧と詳細に必要な読み取り情報 | 別々のTaskではなく同じIDの表示目的の違い |
| 空一覧 | 取得に成功し、Taskが0件 | 取得中・取得失敗は空一覧の証拠ではない |
| 削除 | 記録を削除し復元を提供しない | 完了状態への変更やアーカイブではない |

例: 一覧でID=42を選ぶと、そのIDの詳細へ進む。取得に失敗したときは「記録がない」と説明しない。

根拠: [TaskRepository](../../apps/backend/app/Repositories/Task/TaskRepository.php) / [FE contract](../../apps/frontend/src/lib/task/taskCrudFlow.contract.test.ts)。API・入力・DBの詳細は [Pack](../ai/packs/task-crud.md) から4点セットへ。

判断の教材は [Questions](../testing/questions/task-crud.md) と [Issue例](../testing/examples/task-crud-issue.md)。教材の削除仕様を、本番データを破壊する許可に転用しない。
