# Human-on-Exception

> **If AI keeps getting better, how much engineering work actually still needs a human?**  
> This repository takes that question seriously and draws an explicit boundary between human authority and AI execution.

> **Humans decide intent and boundaries. AI owns execution.**

Humans own **Intent / Scope / Answers / Risk acceptance** and the semantic boundaries that define product meaning. AI owns investigation, design, Issue creation, implementation, tests, docs, PR creation, independent review handling, fixes, and re-verification.

Human coding, code reading, and line-by-line code review are not normal required gates. The "Exception" is a decision AI does **not** have authority to make—not an ordinary bug, failing test, or review fix. The authoritative workflow contract is [docs/rules/ai-workflow.md](./docs/rules/ai-workflow.md).


## What is in this repository

- **Execution contract** — responsibility boundaries, Questions, Issues, implementation, and completion
- **Questions / Answers** — AI investigates current state and asks only for decisions requiring human authority
- **Source of Truth rules** — distinguish current-state facts from an agreed target contract
- **Independent AI review** — a separate context verifies AC, SoT, diff, tests, and docs
- **4-point docs** — flow / ui / validation / db as a human-readable current feature overview and verification surface
- **Executable example** — a minimal Laravel / Next.js Task CRUD

Start with README → [AI execution contract](./docs/rules/ai-workflow.md) → [Questions template](./docs/templates/questions.md) → [Task CRUD example](./docs/testing/questions/task-crud.md) → [Independent AI review](./docs/rules/ai-review.md).

## Human prompts / 人間が使うプロンプト

Optional bootstrap for a new product: [0. Greenfield bootstrap](./prompts/00-greenfield.md). The normal development loop remains the five entry/resume prompts below.

新規プロダクトでは必要に応じて [0. Greenfield bootstrap](./prompts/00-greenfield.md) を先に使う。通常の開発ループは以下の5本。

1. [Define Questions / Questions 作成](./prompts/01-define.md) — [existing repo](./prompts/01-define-existing.md) / [greenfield](./prompts/01-define-greenfield.md)
2. [Apply Answers / Create Issue / Answers 反映・Issue 起票](./prompts/02-decide.md)
3. [Implement Issue / PR / Issue 実装・PR](./prompts/03-implement.md)
4. [Resolve PR review / PR 指摘対応](./prompts/04-review.md)
5. [Merge / update target branch / マージ・対象ブランチ更新](./prompts/05-merge.md)

Normal flow / 通常の流れ:

```text
Human: I want this feature.
人間: この機能を作りたい
  ↓
AI: investigate the current contract, or design from repo rules in greenfield mode, then create Questions
AI: 既存契約を調査する。ゼロプロなら repo ルールから設計仮説を作り、Questions を作成する
  ↓
Human: answer only the decisions
人間: 意思決定だけ Answers を更新する
  ↓
AI: if no blocker remains, create the Issue and own implementation, tests, 4-point docs, and PR
AI: blocker が無ければ Issue を起票し、実装・テスト・4点セット docs・PR まで作る
  ↓
Independent-context AI reviews the PR
別人格 AI が PR をレビューする
  ↓
Implementation AI classifies findings against SoT, fixes valid ones, and returns only decision exceptions to the human
実装 AI が SoT で指摘を判定し、妥当なら修正。判断不能な意味だけ人間へ戻す
```

## Anti-misreading principles / 読み違えを防ぐ原則

- Do not infer product purpose from implementation size, file count, or familiar product categories. Read concept, human answers, and accepted decisions first.  
  実装量・ファイル数・既存カテゴリからプロダクト目的を逆算しない。concept、人間回答、Accepted decision を先に読む。
- Authentication actor, operator, owner/manager, experience/record subject, and search/decision actor may differ. FK/login structure alone does not define the domain protagonist.  
  認証主体・操作主体・所有/管理主体・体験/記録主体・検索/判断主体は同一とは限らない。FK やログイン構造だけでドメイン主体を決めない。
- A bulk UI operation does not imply one persisted/editable/unique domain record.  
  UI の一括入力・一括操作と、保存・編集・一意性の単位を混同しない。
- Do not promote internal scores, candidates, references, or inferences into confirmed facts or recommendations unless the agreed meaning allows it.  
  内部評価値・候補・参考・推定を、合意なく確定事実や推薦へ昇格しない。
- MVP does not mean minimum file count. Semantic distinctions required to test the value hypothesis may be part of the MVP.  
  MVP を「ファイルや機能が少ない状態」と定義しない。価値仮説の検証に必要な意味の区別は MVP に含まれ得る。

## Quality model / 品質を維持する仕組み

- **concept**: purpose and core concepts / 目的と主要概念
- **ADR**: durable adopted reasons / 継続する設計判断と採用理由
- **Policy**: repeatable agreed criteria AI may apply / AI が反復適用できる合意済み基準
- **Questions**: evidence, options, recommendations, unresolved items, answers, revision history / 要件定義・Q&A・決定履歴
- **Issue**: agreed answers converted into observable acceptance criteria and mapped to Flow/tests/docs
- **Execution**: implementation, verification, self-review, and evidence are AI-owned
- **Independent review**: Codex / Cursor Bugbot or another separate-context reviewer
- **Completion**: required checks pass, valid findings are resolved, and AC are evidenced

[Questions template](./docs/templates/questions.md) · [workflow conformance](./docs/testing/workflow-conformance.md) · [AI review](./docs/rules/ai-review.md)

The 4-point set is a human-readable current feature overview maintained by AI and also a verification surface for implementation/tests. Human code or document approval is not a normal gate.

The five prompts are entry/resume points, not five human approval gates. Once answers and permissions are sufficient, AI continues authorized stages.


## Adoption / 導入

Human-on-Exception is not limited to greenfield repositories. Existing codebases can adopt the workflow by first letting AI reconstruct the current contracts from implementation and tests, then create or align the 4-point docs, concept, Questions, ADR, and Policy only where they are needed. No greenfield rewrite is required.

Human-on-Exception は新規リポジトリ専用ではない。既存リポジトリでも、まず AI が実装とテストから現状契約を調査・再構成し、必要な 4 点セット docs、concept、Questions、ADR、Policy を整備・整合させたうえで、同じ Human-on-Exception の開発ループへ移行できる。新規開発として作り直す必要はない。

For a new product, run `make greenfield DRY_RUN=1` first. After confirming the plan, run `make greenfield CONFIRM=1`. The executable example is archived locally under gitignored `.trash/`, active references are reset to zero-product state, and the workflow/rules/templates/application skeleton remain. Then begin with [1B. Greenfield](./prompts/01-define-greenfield.md).

新規プロダクトとして使う場合は、まず `make greenfield DRY_RUN=1` で対象を確認し、問題なければ `make greenfield CONFIRM=1` を実行する。実行教材は gitignore 対象の `.trash/` へローカル退避され、active reference は product 0 件へ初期化される。workflow / rules / templates / application skeleton は残り、その後 [1B. Greenfield](./prompts/01-define-greenfield.md) から開始する。

## Local startup

Docker Compose V2:

```bash
make up
```

- Frontend: http://localhost:3000/
- Task list: http://localhost:3000/tasks/
- Backend health: http://localhost:8080/up
- Backend API: http://localhost:8080/api/tasks
- PostgreSQL: localhost:5432

Stop:

```bash
make down
```

Rebuild:

```bash
make build
make up
```

Backend startup applies DB migrations automatically. `make init-db` / `make reset-db` are also available.

Create a Task:

```bash
curl -X POST http://localhost:8080/api/tasks \
  -H 'Content-Type: application/json' \
  -d '{"title":"Try Human-on-Exception","description":"Laravel sample"}'
```

## Development commands

```bash
make lint
make test
make survey
make docs
```

## Source of Truth

When current-state sources conflict, follow [AGENTS.md](./AGENTS.md):

```text
implementation → system test → docs/flow → coverage/*
```

Current behavior is code + flow / ui / validation / db. Purpose/core concepts live in `docs/concept/`; decision history in `docs/testing/questions/`; active design decisions in `docs/testing/adr/`; repeatable criteria in `docs/testing/policy/`.

## Sample

The repository includes one minimal sample bundle: `EXAMPLE_TASK_CRUD`.

- Pack: [docs/ai/packs/task-crud.md](./docs/ai/packs/task-crud.md)
- Flow: [docs/flow/タスクCRUD.md](./docs/flow/タスクCRUD.md)
- Questions: [docs/testing/questions/task-crud.md](./docs/testing/questions/task-crud.md)
- Backend: `apps/backend/`
- Frontend: `apps/frontend/`
