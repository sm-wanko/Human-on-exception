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
| `db` | repository/query/model/migration/transaction behavior | reads/writes as SQL statements, including the `WHERE`, `ON CONFLICT`, or `FOR UPDATE` that decides the result; persisted meaning; transaction/order/concurrency effects; explicit N/A when no persistence responsibility exists. A source path does not satisfy this |

Do not copy the same prose into all four documents. Each document owns its responsibility as defined by `docs/rules/docs-follow.md`.

Current-state docs must describe **what the repository actually does now**. Do not silently "correct" suspicious behavior into an intended design.

If implementation and existing docs disagree, establish current facts using the repository Source of Truth order. Record contradictions or missing evidence explicitly.

`docs/flow` owns the section `## 未検証事項・矛盾`. That list holds inconsistent current behavior, estimates that were not executed, and tests that do not exist. `ui`, `validation`, and `db` get one sentence and a link. Do not copy the list, and do not rewrite it into an intended design.

A fact the code already determines stays a fact. If changing it would require a human decision, label it `Question candidate when this behavior is changed` and do not open a Question in this prompt. Do not draft concept, ADR, or Policy when the product has none.

Put a `*-SYS-*` or `*-FE-*` token in the flow matrix only when a test with that name exists. Describe a missing test under `## 未検証事項・矛盾`. An ID in that section is missing evidence, not a matrix claim, and survey does not require a matching test. A matrix row remains a claim that the test exists, including a row that says `未実装`.

When the implementation lives in another repository, prefix paths with that repository's name and record the inspected commit and branch on the flow. Completion commands are commands that exist in the repository that holds the code. If the human says not to record them, record that omission as missing evidence. Do not substitute this sample's `make test` or `make survey`. Survey in this repository checks documents here. It does not read the other repository. Do not reuse a sample Pack or Flow ID for the product.

### 3. Create or update a Pack

Create or update `docs/ai/packs/<pack>.md` as the bounded navigation and evidence bundle.

A Pack may contain **bounded N related Flow IDs** when they belong to one cohesive feature area, as in a create/edit/delete family. It must not become a catch-all domain directory.

Include:

- Pack boundary: included and excluded flows / entry points
- 4-point doc links per Flow ID
- relevant frontend/backend/worker/integration implementation paths
- existing SYS / FE / integration test IDs and paths
- completion / verification commands that actually exist in the repository that holds the code
- known missing evidence, explicitly marked as missing rather than passed
- `docs/testing/core-features.md`: the bundle, Pack, Flow ID, implementation paths, and completion commands that actually exist

Do not invent tests, commands, IDs, or successful verification. Do not copy flow bodies into the Pack or the index.

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
- Pack, 4-point files, and feature index created/updated
- entry points and implementation paths inspected
- tests/evidence mapped
- commands actually run and their results
- contradictions / missing evidence
- actors, units, and evidence strength: the fact the code determines, or a reasoned N/A. Do not open a Question only because a dimension matters
- any true human-authority Questions
- Question candidates that stay closed until that behavior is changed
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
- `db`: read/write を SQL で書く。結果を決める `WHERE` / `ON CONFLICT` / `FOR UPDATE` を含める。persisted meaning、transaction/order/concurrency。永続化責務が無ければ N/A。ソースファイルへのパスでは、この節を満たさない

4 ファイルへ同じ説明を複製せず、`docs/rules/docs-follow.md` の責務分離に従うこと。

current-state docs は **repo が現在実際に行うこと**を書く。怪しい挙動を勝手に「あるべき仕様」へ直さない。

実装と既存 docs が食い違うときは、repository の Source of Truth 順で現状事実を確定し、矛盾または evidence の欠落を明示して記録すること。

`docs/flow` が `## 未検証事項・矛盾` を持つ。不整合な現行挙動、実行していない推定、存在しないテストをそこへ書く。`ui` / `validation` / `db` は一文とリンクだけとし、一覧を写さない。意図した仕様へ書き換えない。

コードで既に決まる事実は事実のまま書く。それを変えるのに人間の決定が要るなら、`この挙動を変えるときの Question 候補` とラベルし、この prompt では Question を開かない。製品に concept / ADR / Policy が無いとき、00 で起草しない。

`*-SYS-*` / `*-FE-*` を flow のマトリクスに置くのは、その名前のテストが存在するときだけである。無いテストは `## 未検証事項・矛盾` に書く。その節の ID はマトリクスの主張ではなく、survey は対応するテストを要求しない。マトリクス行は、`未実装` と書いてあっても、テストが存在するという主張のままである。

実装が別リポジトリにあるときは、パスの頭にそのリポジトリ名を付け、調べた commit と branch を flow に記録する。完了コマンドは、コードがあるリポジトリに実在するコマンドだけを書く。人間が記録しないと言った場合は、欠落として記録し、この見本の `make test` や `make survey` を代わりに書かない。このリポジトリの survey は、ここにある文書を見る。別リポジトリのコードは読まない。見本の Pack 名や Flow ID を製品に再利用しない。

### 3. Pack を作成または更新する

`docs/ai/packs/<pack>.md` を bounded な navigation / evidence bundle として作成・更新すること。

create/edit/delete 系のように 1 つのまとまりを構成する場合は、1 Pack に **bounded N の関連 Flow ID** を含めてよい。ただし巨大な domain directory にしない。

含めるもの:

- Pack の include / exclude 境界
- Flow ID ごとの 4 点セット
- 関係する実装 path
- 既存 SYS / FE / integration test ID と path
- コードがあるリポジトリに実在する completion / verification command
- evidence 欠落は success にせず missing と明示
- `docs/testing/core-features.md`: 束、Pack、Flow ID、実装 path、実在する completion command

test・command・ID・成功結果を捏造しないこと。flow 本文を Pack にも索引にも複製しないこと。

### 4. Questions は repo から復元できない「意味」だけ

docs が無いこと自体は AI-owned reconstruction であり、人間への Question ではない。

repo facts、tests、accepted concept / ADR / Policy、existing behavior から確定できない semantic / actor-boundary / aggregation-unit / time-semantics / destructive-risk / authority decision のみ Question にすること。

通常 Question にしない例:

- file name
- document placement
- Flow ID の命名
- framework convention
- 既知の挙動をどの controller / service / repository が実装しているか
- code / test から観測できる既存の error / status / transaction の文書化

現在の挙動自体が不整合なときは、次を分けること。

1. 文書化できる事実
2. 矛盾または欠落
3. 本当に人間の権限が必要な意味決定

疑わしい bug を新しい product decision に変換しないこと。

### 5. 導入は documentation-first

この prompt では 4 点セットを綺麗にするために product behavior を変更しないこと。

実装・tests を読み、4 点セットと Pack を作成・整合し、既存 evidence を mapping し、矛盾・未検証を報告する。このパスで実行するのは、docs 変更に必要で repository に実在する documentation / survey / lint command だけである。

追加 test、refactor、bug fix、behavior change が必要なら follow-up として提案し、挙動変更は `prompts/01-define-existing.md` から通常 workflow を開始すること。

### 6. bounded unit を 1 つずつ進める

人間が明示的に batch を指定しない限り、1 単位を完成させて停止すること。

完了時に以下を報告すること。

- 指定された seed と、実際に辿った関連 path
- 選択した Flow ID と、その behavioral boundary が妥当な理由
- 作成・更新した Pack / 4 点セット / feature index
- 調査した entry point / implementation path
- mapping した tests / evidence
- 実行した command と実結果
- contradiction / missing evidence
- 主体、単位、証拠の強さ。コードが決める事実、または理由付き N/A。観点が重要だというだけでは Question を開かない
- 本当に必要な human-authority Questions
- その挙動を変えるときまで開かない Question 候補
- 次候補となる seed / uncovered unit（提案だけ。明示依頼がない限り続行しない）

repo は段階導入できる。未整備領域について契約を推測してよいという意味ではない。
