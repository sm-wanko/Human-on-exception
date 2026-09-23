# Docs N/A 宣言規約

## 目的

DB 書き込み・参照がない API や、クライアント入力バリデーションの対象がない API は、単なる「書き忘れ」と区別するために各仕様 docs で明示的に **N/A** と宣言する。

## 基本原則

### 正本のみ記載（経緯・旧仕様は書かない）

`docs/flow` / `docs/ui` / `docs/validation` / `docs/db` は **現行実装・現行契約の正本**。

- **書く**: いまの API 契約・DB 状態・SIT 期待値
- **書かない**: 旧 status、旧 ID、移行経緯
- 経緯は `docs/testing/questions/`、有効な決定は `docs/testing/adr/`

### N/A の扱い

- N/A は **当該観点の責務がないことを明示する仕様記述**
- DB 非関与は `docs/db/*.md`
- Validation 非適用は `docs/validation/*.md`
- 外部 API / cache / auth 等の別責務は N/A で消さない

## 標準セクション名

### DB docs

```markdown
## DB 非関与エンドポイント（N/A）
```

### Validation docs

```markdown
## バリデーション非適用エンドポイント（N/A）
```

## 推奨テーブルフォーマット

| method | path | 振る舞い | 実装ファイル |
|---|---|---|---|
| GET | `/api/example` | DB を触らず固定値を返す | `apps/backend/...` |

## レビュー時のチェックポイント

- 標準セクション名が完全一致
- method / path が実装 route と一致
- N/A 理由が実装根拠を持つ
- N/A で別責務を隠していない

## アンチパターン

- N/A と書きながら DB を触る
- N/A と書きながら入力検証が必要
- 「未調査」「たぶん不要」を N/A 理由にする
- API 仕様の欠損を N/A で隠す

## SIT マトリクスにおけるスコープ外の明示

`docs/flow/*.md` のテストマトリクスで縦串 SIT に含めない境界は:

```markdown
### SIT スコープ外（N/A）
```

として対象経路・理由を明示する。未着手と混同しない。
