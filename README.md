# Human-on-Exception

Paw-Pads で実際に使っている AI 開発環境からペットドメインを外し、Backend を Laravel に置き換えた最小サンプル。

考え方は一つだけ。

> **人間が開発ループのボトルネックになり得るなら、人間は「何を作るか」と未決事項への回答だけを持ち、AI が調査・Questions・Issue・実装・docs・PR・レビュー対応を行う。**

## 人間が使う 5 本のプロンプト

1. [Questions 作成](./prompts/01-define.md)
2. [Answers 反映 / Issue 起票](./prompts/02-decide.md)
3. [Issue 実装 / PR](./prompts/03-implement.md)
4. [PR 指摘対応](./prompts/04-review.md)
5. [マージ / develop 更新](./prompts/05-merge.md)

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

## Paw-Pads との差分

- ペット固有の機能・検索・データ・用語は含めない
- Backend の実装例は Go ではなく Laravel
- Frontend は TypeScript / Next.js
- AI 開発環境の構造・SoT・Pack / Flow / Questions / 4点セット / SIT / FE Contract / review 方針は Paw-Pads の形式に合わせる

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

現在仕様は code + flow / ui / validation / db。要件定義の経緯は `docs/testing/questions/`、有効な設計決定は `docs/testing/adr/`。

## サンプル

`TASK_CRUD` を 1 本だけ入れている。

- Pack: [docs/ai/packs/task-crud.md](./docs/ai/packs/task-crud.md)
- Flow: [docs/flow/タスクCRUD.md](./docs/flow/タスクCRUD.md)
- Questions: [docs/testing/questions/task-crud.md](./docs/testing/questions/task-crud.md)
- Backend: `apps/backend/`
- Frontend: `apps/frontend/`
