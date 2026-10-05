# Existing repository adoption / 既存 repo 導入

## English

<seed file(s) / path(s) / explicit entry point>

Examples:
- `apps/backend/app/Http/Controllers/PetController.php`
- `routes/api.php: POST /api/pets`
- `src/features/pet/PetEditPagePresentation.tsx`
- multiple directly related seed files

Use this prompt to introduce Human-on-Exception into an existing repository **without rewriting the product or changing behavior**. The goal is to reconstruct the current feature contract one bounded unit at a time so later AI work can rely on explicit 4-point docs and Packs.

Follow `AGENTS.md`, `docs/rules/docs-follow.md`, `docs/rules/ai-workflow.md`, `docs/rules/domain-decisions.md`, and the current-state Source of Truth order.

### 1. Start from the supplied seed, then choose the adoption unit from behavior

The human supplies the exploration seed. Do not begin by scanning the whole repository to decide what to document first.

Start from the supplied file(s), path(s), endpoint, route, controller action, screen, job, webhook, or equivalent entry point. From that seed, trace only the directly related behavior needed to reconstruct its bounded contract: routes, controllers/handlers, screens, tests, services, repositories, persistence, and existing docs.

The seed defines where investigation starts; it does **not** automatically define the documentation boundary.

Use **one user-observable or externally callable behavior** as the default unit.

- A single API endpoint / route action is usually one unit when it has its own input, authorization, errors, persistence, or verification contract.
- If one controller contains several semantically independent actions, split them into separate Flow IDs. Do not make "one controller = one feature" a mechanical rule.
- A screen-only flow, background job, command, webhook, scheduled task, or integration entry point may be its own unit even when no controller exists.
- Combine a bounded number of entry points only when they form one cohesive behavior that cannot be understood or verified independently.
- Do not merge list/detail, create/update, actor roles, aggregation units, or other distinct meanings merely because code is shared.

State the selected boundary, included entry points, excluded neighboring behavior, and proposed stable Flow ID before writing the bundle. Boundary selection that follows repository facts is AI execution. Ask the human only if choosing the boundary would change product meaning or authority.

### 2. Reconstruct the current 4-point set

Create or align one cohesive 4-point set anchored at `docs/flow/<feature>.md`.

| Document | Reconstruct from current implementation/tests | Required content |
|---|---|---|
| `flow` | route/controller/handler, orchestration, tests | Scope, actor/entry point, normal flow, error branches, API/order, SYS/FE test matrix |
| `ui` | route/page/component/client behavior | display, interaction, loading/error/success/return behavior; explicit N/A when no UI responsibility exists |
| `validation` | parser/request/auth/domain validation/error mapping | inputs, required/optional rules, authorization, normalization, errors; explicit N/A when absent |
| `db` | repository/query/model/migration/transaction behavior | reads/writes, persisted meaning, transaction/order/concurrency effects; explicit N/A when no persistence responsibility exists |

Do not copy the same prose into all four documents. Each document owns its responsibility as defined by `docs/rules/docs-follow.md`.

Current-state docs must describe **what the repository actually does now**. Do not silently "correct" suspicious behavior into an intended design.

If implementation and existing docs disagree, establish current facts using the repository Source of Truth order. Record contradictions or missing evidence explicitly.

### 3. Create or update a Pack

Create or update `docs/ai/packs/<pack>.md` as the bounded navigation and evidence bundle.

A Pack may contain **bounded N related Flow IDs** when they belong to one cohesive feature area, as in a create/edit/delete family. It must not become a catch-all domain directory.

Include:

- Pack boundary: included and excluded flows / entry points
- 4-point doc links per Flow ID
- relevant frontend/backend/worker/integration implementation paths
- existing SYS / FE / integration test IDs and paths
- completion / verification commands that actually exist in this repository
- known missing evidence, explicitly marked as missing rather than passed

Do not invent tests, commands, IDs, or successful verification.

### 4. Questions are only for unrecoverable meaning

Missing documentation is an AI-owned reconstruction task, not a human question.

Create a Question only when repository facts, tests, accepted concept / ADR / Policy, and existing behavior cannot determine a semantic, actor-boundary, aggregation-unit, time-semantics, destructive-risk, or authority decision.

Examples of things that normally do **not** require a Question:

- file names
- document placement
- Flow ID naming
- framework conventions
- which controller/service/repository implements known behavior
- documenting an existing error/status/transaction that can be observed from code/tests

If current behavior itself is inconsistent, distinguish:
1. facts that can be documented,
2. contradictions or gaps,
3. semantic decisions that truly require human authority.

Do not convert a suspected bug into a new product decision.

### 5. Adoption is documentation-first

For this prompt, do not change product behavior merely to make the 4-point set cleaner.

- Read implementation and tests.
- Create/align the 4-point set and Pack.
- Map existing evidence.
- Report uncovered or contradictory areas.
- Run only repository-native documentation / survey / lint commands required for documentation changes when available.

If stronger tests, refactors, bug fixes, or behavior changes are needed, propose them as follow-up work. Start the normal change workflow with `prompts/01-define-existing.md` when product behavior is to change.

### 6. Work one bounded unit at a time

Unless the human explicitly requests a wider batch, complete one selected unit and stop.

At completion, report:

- supplied seed and the related paths actually followed
- selected Flow ID and why this is the correct behavioral boundary
- Pack and 4-point files created/updated
- entry points and implementation paths inspected
- tests/evidence mapped
- commands actually run and their results
- contradictions / missing evidence
- any true human-authority Questions
- recommended next seed / uncovered unit (suggestion only; do not continue unless explicitly requested)

The repository can adopt Human-on-Exception incrementally. A partially documented repository is not permission to invent contracts for uncovered areas.

---

## 日本語

<seed file(s) / path(s) / 明示的な entry point>

例:
- `apps/backend/app/Http/Controllers/PetController.php`
- `routes/api.php: POST /api/pets`
- `src/features/pet/PetEditPagePresentation.tsx`
- 直接関連する複数 seed file

既存 repo に Human-on-Exception を導入するとき、**プロダクトを書き直したり挙動を変更したりせず**、現状契約を小さな単位で再構成するために使う。後続の AI 実行が明示的な 4 点セットと Pack を参照できる状態を作ることが目的。

`AGENTS.md`、`docs/rules/docs-follow.md`、`docs/rules/ai-workflow.md`、`docs/rules/domain-decisions.md` と current-state Source of Truth 順に従うこと。

### 1. 指定された seed から開始し、「挙動」で導入単位を決める

探索開始点は人間が指定する。最初に repo 全体を走査して「何を docs 化するか」を AI が決めるところから始めないこと。

指定された file / path / endpoint / route / controller action / screen / job / webhook 等を seed とし、そこから bounded contract を再構成するために直接必要な関連だけを辿ること。route、controller/handler、screen、test、service、repository、persistence、既存 docs を必要な範囲で追う。

seed は探索開始点であり、docs の境界そのものを自動的に意味しない。

原則として **利用者から観測できる、または外部から呼び出せる 1 つの挙動**を 1 単位とする。

- API endpoint / route action が独立した input・authorization・error・persistence・verification 契約を持つなら、通常は 1 単位。
- 1 controller に意味の異なる複数 action がある場合は Flow ID を分ける。「1 controller = 1 feature」を機械的な規則にしない。
- controller がなくても、screen-only flow、background job、command、webhook、scheduled task、integration entry point は独立単位になりうる。
- 独立して理解・検証できない一体の挙動だけ bounded N でまとめる。
- code が共有されているだけで list/detail、create/update、actor、aggregation unit など意味の違うものを統合しない。

docs 作成前に、選択した境界・含む entry point・除外する隣接挙動・提案 Flow ID を明示すること。repo の事実から決まる境界選択は AI execution。product meaning / authority を変える場合だけ人間へ戻すこと。

### 2. current 4 点セットを再構成する

`docs/flow/<feature>.md` を anchor に、cohesive な 4 点セットを作成または整合すること。

- `flow`: Scope、actor / entry point、normal flow、error branch、API/order、SYS/FE test matrix
- `ui`: 表示、interaction、loading/error/success/return。UI 責務が本当に無ければ理由付き N/A
- `validation`: input、required/optional、authorization、normalization、error。責務が無ければ N/A
- `db`: read/write、persisted meaning、transaction/order/concurrency。永続化責務が無ければ N/A

4 ファイルへ同じ説明を複製せず、`docs/rules/docs-follow.md` の責務分離に従うこと。

current-state docs は **repo が現在実際に行うこと**を書く。怪しい挙動を勝手に「あるべき仕様」へ直さない。

### 3. Pack を作成または更新する

`docs/ai/packs/<pack>.md` を bounded な navigation / evidence bundle として作成・更新すること。

create/edit/delete 系のように 1 つのまとまりを構成する場合は、1 Pack に **bounded N の関連 Flow ID** を含めてよい。ただし巨大な domain directory にしない。

含めるもの:

- Pack の include / exclude 境界
- Flow ID ごとの 4 点セット
- 関係する実装 path
- 既存 SYS / FE / integration test ID と path
- repo に実在する completion / verification command
- evidence 欠落は success にせず missing と明示

test・command・ID・成功結果を捏造しないこと。

### 4. Questions は repo から復元できない「意味」だけ

docs が無いこと自体は AI-owned reconstruction であり、人間への Question ではない。

repo facts、tests、accepted concept / ADR / Policy、existing behavior から確定できない semantic / actor-boundary / aggregation-unit / time-semantics / destructive-risk / authority decision のみ Question にすること。

疑わしい bug を新しい product decision に変換しないこと。

### 5. 導入は documentation-first

この prompt では 4 点セットを綺麗にするために product behavior を変更しないこと。

実装・tests を読み、4 点セットと Pack を作成・整合し、既存 evidence を mapping し、矛盾・未検証を報告する。docs change に必要な repo-native docs / survey / lint command があれば実行する。

追加 test、refactor、bug fix、behavior change が必要なら follow-up として提案し、挙動変更は `prompts/01-define-existing.md` から通常 workflow を開始すること。

### 6. bounded unit を 1 つずつ進める

人間が明示的に batch を指定しない限り、1 単位を完成させて停止すること。

完了時に以下を報告すること。

- 指定された seed と、実際に辿った関連 path
- 選択した Flow ID と、その behavioral boundary が妥当な理由
- 作成・更新した Pack / 4 点セット
- 調査した entry point / implementation path
- mapping した tests / evidence
- 実行した command と実結果
- contradiction / missing evidence
- 本当に必要な human-authority Questions
- 次候補となる seed / uncovered unit（提案だけ。明示依頼がない限り続行しない）

repo は段階導入できる。未整備領域について契約を推測してよいという意味ではない。
