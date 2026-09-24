# Human-on-Exception

人間が目的と境界を決め、AI が調査から実装・検証・PR・レビュー対応までを担う、汎用スタートアップ向け開発リポジトリ。Laravel / Next.js の最小 Task CRUD を実例として含む。

考え方は一つだけ。

> **Humans decide intent and boundaries. AI owns execution.**

人間の役割は **Intent / Scope / Answer / Risk acceptance**。特に、何を同じ概念として扱うか・何を別の意味として残すかという **semantic boundary（意味の境界）** は人間が所有する。AI はその判断を仕様・設計・実装・テスト・docs へ展開するが、未合意の意味を「自然そうだから」と確定する semantic authority は持たない。

人間によるコーディング・逐次コードレビューを通常フローから外し、コードを読めることを利用条件にしない。任意の人間レビューは可能だが required gate にしない。

この名前の Exception は **AI に判断権限がない意思決定**を指す。通常の実装エラー・テスト失敗・レビュー修正は AI が解決する。[実行契約](./docs/rules/ai-workflow.md) が全工程の正本。

## 人間が使う 5 本のプロンプト

1. [Questions 作成](./prompts/01-define.md)
2. [Answers 反映 / Issue 起票](./prompts/02-decide.md)
3. [Issue 実装 / PR](./prompts/03-implement.md)
4. [PR 指摘対応](./prompts/04-review.md)
5. [マージ / 対象ブランチ更新](./prompts/05-merge.md)

通常の流れ:

```text
人間: この機能を作りたい
  ↓
AI: repo を調べて Questions を作る
  ↓
人間: Answers を更新する
  ↓
AI: 不明が無ければ Issue を起票し、実装・テスト・4点セット docs・PR まで作る
  ↓
別人格 AI: PR をレビューする
  ↓
実装 AI: 指摘を SoT で判定し、妥当なら修正。判断不能な点だけ人間へ戻す
```

## 読み違えを防ぐ原則

- 実装量・ファイル数・既存カテゴリから、プロダクトの目的を逆算しない。目的は concept、人間回答、Accepted ADR から先に読む。
- 認証する人、操作する人、体験・記録の主体、検索・判断する人が同一とは限らない。FK やログイン構造だけでドメイン主体を決めない。
- UI で一括入力・一括操作できても、保存・編集・一意性の単位が同じとは限らない。「1操作」と「1件の意味」を分ける。
- 内部評価値・候補・参考・推定を、利用者向けの確定事実や推薦へ勝手に昇格しない。
- MVP を「ファイルや機能が少ない状態」と定義しない。価値仮説を検証するために必要な意味の区別は、簡略化で失わない。

## 品質を維持する仕組み

- 判断の根拠: concept で目的と概念、ADR で採用理由、Policy で合意済みの反復判断を保持する
- Questions: 現状の根拠、選択肢の影響、推奨理由、未決・回答・改訂履歴
- Issue: 合意した回答から受け入れ条件へ変換し、Flow / テスト / docs まで対応付ける
- 実行: 実装・検証・自己レビュー・証拠作成を AI が所有する
- 独立レビュー: Codex / Cursor Bugbot 等が実装者の自己レビューとは別のコンテキストで評価する
- 完了: 必須チェック成功、妥当指摘解消、受け入れ条件充足を AI が確認する

[Questions テンプレート](./docs/templates/questions.md) · [継承要件と検証例](./docs/testing/workflow-conformance.md) · [レビュー運用](./docs/rules/ai-review.md)

[プロダクト概念の入口](./docs/concept/README.md) · [意味と判断の継承](./docs/rules/domain-decisions.md) · [Policyの役割](./docs/testing/policy/README.md)。4点セットは人間が機能を理解する資料としてAIが維持し、人間の文書・コードレビューを通常ゲートにしない。

5 本は開始・再開の入口であり、工程ごとに人間の操作を要求するゲートではない。回答と範囲が確定すれば、許可済み工程を続行する。外部レビューサービスの接続・実行権限は導入環境で必要。規約ファイルを置くだけではサービスは起動しない。

## ローカル起動

Docker Compose V2 があれば、初回もこれだけで起動する。

```bash
make up
```

- Frontend: http://localhost:3000/
- Task list: http://localhost:3000/tasks/
- Backend health: http://localhost:8080/up
- Backend API: http://localhost:8080/api/tasks
- PostgreSQL: localhost:5432

停止:

```bash
make down
```

再ビルド:

```bash
make build
make up
```

DB migration は backend 起動時に自動適用する。`make init-db` / `make reset-db` でも実行可能。

Task を作る例:

```bash
curl -X POST http://localhost:8080/api/tasks   -H 'Content-Type: application/json'   -d '{"title":"Try Human-on-Exception","description":"Laravel sample"}'
```

## 開発コマンド

```bash
make lint
make test
make survey
make docs
```

## Source of Truth

矛盾時は [AGENTS.md](./AGENTS.md) に従う。

```text
implementation → system test → docs/flow → coverage/*
```

現在仕様は code + flow / ui / validation / db。目的と概念は `docs/concept/`、要件定義の経緯は `docs/testing/questions/`、有効な設計決定は `docs/testing/adr/`、反復作業の判断基準は `docs/testing/policy/`。

## サンプル

`TASK_CRUD` を 1 本だけ入れている。

- Pack: [docs/ai/packs/task-crud.md](./docs/ai/packs/task-crud.md)
- Flow: [docs/flow/タスクCRUD.md](./docs/flow/タスクCRUD.md)
- Questions: [docs/testing/questions/task-crud.md](./docs/testing/questions/task-crud.md)
- Backend: `apps/backend/`
- Frontend: `apps/frontend/`
