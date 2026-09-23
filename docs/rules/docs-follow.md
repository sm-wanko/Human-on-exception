# Docs 追従（正本）

flow / ui / validation / db・遷移・テスト ID の **同一変更系列**での揃え方。N/A の書き方は [`docs-na-conventions.md`](./docs-na-conventions.md)。SIT 戦略は [`system-test-strategy.md`](./system-test-strategy.md)。

---

## MUST

- **4 点セットを同一変更系列で揃える**: `docs/flow/<機能>.md` をアンカーに、関連する `docs/ui` / `docs/validation` / `docs/db` を同じ PR / 変更系列で更新する。
- **`docs === 実装`**: Scope / Entry Point / Normal Flow / **テストマトリクス**を実装と矛盾させない。
- **不要な観点は N/A**: 本当に責務が無いクアドラントだけ省略し、該当 docs で **N/A** と明示する。
- **画面追加**: route 追加時は同一変更系列で [`docs/transition/遷移定義.md`](../transition/遷移定義.md) を更新し、`make docs` / `make survey`。
- **SYS-ID / FE-ID を追従**: Backend 縦串は `*-SYS-*`、画面起点の契約は `*-FE-*` を併記し、テスト名と突き合わせ可能にする。
- **SIT 不能はマトリクスで N/A**: 外部本番サービス等は理由付き N/A。未着手と混同しない。

## 4 点セットの責務（文章コピー禁止）

| 文書 | 書くこと |
|------|----------|
| `flow` | ユーザー導線、API 順序、テストマトリクス |
| `ui` | 画面表示・操作 |
| `validation` | 入力、認証、エラー |
| `db` | 永続状態、Tx、更新結果 |

同じ API レスポンス定義・正常系・エラーコード表を複数ファイルにコピーしない。

## 機能単位（1 : 有界な N）

- 同一機能は原則 **4 点セット**を上限とする。
- 新規は `docs/templates/` または既存セットの複製から束ねて追加する。

## 完了コマンド（docs 触ったとき）

- `make docs` / `make survey`。詳細はルート [`AGENTS.md`](../../AGENTS.md)。
