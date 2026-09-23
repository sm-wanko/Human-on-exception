# 監査（会員経由の永続化）

画面または認証済み API からの **会員向け mutation**（登録・更新・削除相当の DB 書き込み）における監査カラム（`created_by` / `created_app` / `updated_*`）の正本。

ツール専用フック: [`.cursor/rules/01-audit-ui-persistence.mdc`](../../.cursor/rules/01-audit-ui-persistence.mdc)、[`.github/copilot-instructions.md`](../../.github/copilot-instructions.md)。

---

## MUST（実装）

- **Controller**: 認証済みユーザー ID を取得し、**Service の引数に渡す**
- **Service**: mutation の actor / app / action を監査 context/value として Repository へ渡す
- **Repository（write path）**: 監査値を DB に bind。会員経路で `"USER"` / `"system"` 等を場当たり的に直書きしない

Laravel 実装では project の Audit DTO / ValueObject / observer 等、既存方式を正本とする。新しい監査方式を勝手に並立させない。

## MUST（SIT）

- 新規または変更した会員向け mutation は [system-test-strategy.md](./system-test-strategy.md) §4.1 に従い正常系で **DB 監査 assert**
- migration / seed / fixture 由来の行は画面経路監査の対象外

## スキーマ上監査列が無いテーブル

監査列がない junction 等へ、本 rule だけを理由に migration を追加しない。親行または既存監査方式で追跡する。

## サンプル TASK_CRUD

認証自体が Flow Scope 外のため監査も N/A。これは `docs/validation/タスクCRUD.md` / `docs/db/タスクCRUD.md` に明示する。
