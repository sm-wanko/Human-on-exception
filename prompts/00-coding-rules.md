# Existing area coding rules / 既存領域の実行規則

## English

<area> and <seed file(s) / path(s)>

Examples:
- area `backend`, seeds `apps/backend/app/Http/Controllers/TaskController.php` and `apps/backend/app/Services/TaskService.php`
- area `frontend`, seeds `apps/frontend/src/features/task/TaskList.tsx` and `apps/frontend/src/lib/task/buildTaskList.ts`

Use this prompt when an existing repository has implementation for one area and no written coding rules for that area. Reconstruct the always-read rule file from what that code already does. Do not change product behavior. Do not refactor code so that it matches the text you write.

This prompt does not replace [00-existing-adoption.md](./00-existing-adoption.md). That prompt reconstructs one feature's 4-point set and Pack. This prompt reconstructs execution rules for one implementation area. Neither prompt is a completion gate.

Follow `AGENTS.md`, `docs/rules/ai-workflow.md`, and `docs/rules/language-policy.md` when those files exist. Apply the current-state Source of Truth order. Do not copy Laravel, Next.js, or other sample rules from a template repository.

### 1. One area, from the supplied seeds

The human names the area and supplies the seeds. Do not scan the whole repository to choose the area.

Slots:

- backend → `docs/rules/backend-quick.md`
- frontend → `docs/rules/frontend-quick.md`
- another named area → `docs/rules/<area>-quick.md`

Write one area and stop, unless the human explicitly asks for a batch.

If that slot already contains repository-specific rules, do not replace them. Report that the slot is filled. Continue only when the human explicitly asks to reconstruct that file from current code.

If the named area has no implementation, do not invent rules and do not create the slot.

### 2. A repeated pattern can become a rule. One seed cannot.

Trace only the implementation directly related to the seeds: handlers, services, repositories, UI layers, validation, transactions, errors, and the verification commands those paths already use.

Before writing, state which placements repeat and which disagree.

- The same placement across more than one seed may be written as a current-state rule.
- One seed is not a repository-wide MUST. Record what that seed does, and leave the slot as the minimal file below.
- When placements disagree, do not choose a winner and do not write a MUST for that placement. Keep the rules that do repeat. For the conflicting part, state that no additional rule is adopted.
- If nothing repeats, the whole file is the minimal file.

Minimal file:

```markdown
# <Area> execution policy

No additional repository-specific <area> coding rules.
Follow existing implementation patterns.
When those patterns disagree, do not infer a repository-wide placement rule. Follow the pattern local to the affected feature unless another repository rule decides it.
Verification follows `docs/rules/ai-workflow.md` §4 and this repository's existing `make` targets.
```

Use the area name in the heading. If `ai-workflow.md` is absent, name only verification commands that exist, and do not invent a §4 reference. When the agent-facing language is not English, write those same statements in that language and do not keep an English copy beside them.

Do not invent commands, test names, or layer names that the seeds do not show. Name a verification command only when it exists in this repository.

### 3. The quick file stays short. Detail is optional.

`<area>-quick.md` is the always-read slot. It must exist for the area you were asked to write, once that area has implementation.

Create `docs/rules/<area>-coding-conventions.md` only when a repeated procedure is too long for the quick file. The quick file points at it. Do not create the detail file for the minimal policy. Do not copy the same rules into both files.

Write agent-facing rule text in the language `docs/rules/language-policy.md` selects for agent-facing material. If that policy is absent, write English. Do not add a second language copy. If the human asked to reconstruct a slot that already has a language, preserve that language.

### 4. Documentation only

Do not change product code, tests, or behavior so that the repository matches the new text.

Do not delete implementation or tests because they disagree with the rule you are writing. Record the disagreement. A suspected bug is not a new product decision.

Create a Question only when writing the rule would choose product meaning, an actor boundary, an aggregation unit, or an authority decision. File layout, framework conventions, and which existing pattern is more common are not Questions.

A later refactor or behavior change starts at [01-define-existing.md](./01-define-existing.md).

Run only repository-native documentation or lint commands that this documentation change requires. Do not invent commands.

### 5. Report and stop

Report:

- area and files written, or the existing slot left in place
- seeds and the paths actually followed
- rules adopted because they repeated
- placements that disagreed and were not turned into rules
- verification commands named, and that they exist
- whether a detail file was created
- commands actually run and their results
- any human-authority Question
- a suggested next seed (suggestion only; do not continue)

---

## 日本語

<area> と <seed file(s) / path(s)>

例:
- area `backend`、seed `apps/backend/app/Http/Controllers/TaskController.php` と `apps/backend/app/Services/TaskService.php`
- area `frontend`、seed `apps/frontend/src/features/task/TaskList.tsx` と `apps/frontend/src/lib/task/buildTaskList.ts`

ある領域の実装があり、その領域の実行規則がまだ無い既存 repo で使う。そのコードがすでに行っていることから、常時読む規則ファイルを再構成する。プロダクトの挙動は変えない。書いた文面に合わせてコードをリファクタしない。

このプロンプトは [00-existing-adoption.md](./00-existing-adoption.md) の代わりではない。あちらは 1 機能の 4 点セットと Pack を再構成する。こちらは 1 つの実装領域の実行規則を再構成する。どちらも完了ゲートではない。

`AGENTS.md`、`docs/rules/ai-workflow.md`、`docs/rules/language-policy.md` があるときはそれらに従う。現状の Source of Truth 順を使う。テンプレートリポジトリの Laravel、Next.js、その他のサンプル規則を写さない。

### 1. 指定された seed から、1 領域だけ書く

領域の指定と seed は人間が渡す。repo 全体を走査して領域を決めない。

スロット:

- backend → `docs/rules/backend-quick.md`
- frontend → `docs/rules/frontend-quick.md`
- それ以外の名前付き領域 → `docs/rules/<area>-quick.md`

人間が batch を明示しない限り、1 領域を書いて停止する。

そのスロットにすでにその repo 固有の規則があるときは、置き換えない。スロットが埋まっていると報告する。現状のコードから再構成するよう人間が明示したときだけ続ける。

名前を付けた領域に実装が無いときは、規則を作らず、スロットも作らない。

### 2. 繰り返す配置だけを規則にする。seed が 1 つでは規則にしない

seed に直接関係する実装だけを辿る。handler、service、repository、UI の層、validation、transaction、error、それらの path がすでに使っている検証コマンドである。

書く前に、どの配置が繰り返し、どれが食い違っているかを述べる。

- 2 つ以上の seed で同じ配置なら、現状の規則として書いてよい。
- seed が 1 つだけのときは、repo 全体の MUST にしない。その seed が行っていることを記録し、スロットは下の極小ファイルのままにする。
- 配置が食い違うときは、勝者を選ばず、その配置の MUST を書かない。繰り返している規則は残す。食い違う部分は、追加規則を採用しないと書く。
- 何も繰り返さないときは、ファイル全体を極小ファイルにする。

極小ファイル:

```markdown
# <Area> execution policy

No additional repository-specific <area> coding rules.
Follow existing implementation patterns.
When those patterns disagree, do not infer a repository-wide placement rule. Follow the pattern local to the affected feature unless another repository rule decides it.
Verification follows `docs/rules/ai-workflow.md` §4 and this repository's existing `make` targets.
```

見出しには領域名を使う。`ai-workflow.md` が無いときは、実在する検証コマンドだけを書き、§4 への参照を作らない。エージェント向け言語が英語でないときは、同じ文をその言語で書き、隣に英語の複製を残さない。

seed に現れていない command、test 名、層の名前を作らない。検証コマンドは、この repo に実在するものだけを名指しする。

### 3. quick は短く保つ。詳細ファイルは任意である

`<area>-quick.md` は常時読むスロットである。依頼された領域に実装があるなら、その領域のスロットを置く。

`docs/rules/<area>-coding-conventions.md` は、繰り返す手順が quick に収まらないときだけ作る。quick からそこを指す。極小ファイルのためには詳細ファイルを作らない。同じ規則を両方のファイルへ写さない。

エージェント向けの規則文は、`docs/rules/language-policy.md` がエージェント向け資料に選ぶ言語で書く。その policy が無いときは英語で書く。もう一方の言語の複製は足さない。既存の言語を持つスロットを再構成するよう依頼されたときは、その言語を保つ。

### 4. 文書化するだけである

新しい文面に repo を合わせるために、プロダクトのコード、tests、挙動を変えない。

今書いている規則と食い違うことを理由に、実装や tests を削除しない。食い違いは記録する。疑わしい bug を新しいプロダクト決定にしない。

Question を作るのは、規則を書くことがプロダクトの意味、actor boundary、aggregation unit、または authority の決定を選んでしまうときだけである。ファイル配置、framework の慣習、どちらの既存パターンが多いかは Question にしない。

その後のリファクタや挙動変更は [01-define-existing.md](./01-define-existing.md) から始める。

この文書変更に必要な、repo に実在する documentation または lint のコマンドだけを実行する。コマンドを作らない。

### 5. 報告して停止する

報告すること:

- 書いた領域とファイル、またはそのまま残した既存スロット
- seed と、実際に辿った path
- 繰り返しを理由に採用した規則
- 食い違っていて規則にしなかった配置
- 名指しした検証コマンドと、それらが実在すること
- 詳細ファイルを作ったかどうか
- 実行したコマンドと実結果
- human-authority の Question があればそれ
- 次の seed の提案（提案だけ。続行しない）
