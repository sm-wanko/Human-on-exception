# タスク CRUD — 着手前 QA（確定）

**Status**: 回答済み  
**Issue 候補**: Task CRUD 実装  
**束**: `task-crud`（`TASK_CRUD`）  
**関連**: [core-features.md](../core-features.md) · [タスクCRUD flow](../../flow/タスクCRUD.md) · [task-crud pack](../../ai/packs/task-crud.md)

---

## 用語

| 呼び方 | 意味 |
|--------|------|
| **TaskQuick** | 一覧用 read model。id / title のみ |
| **TaskDetail** | 詳細用 read model。description / timestamps を含む |
| **4 点セット** | flow / ui / validation / db |

---

## 現状（事実）

| 層 | 状態 |
|----|------|
| **Backend** | Laravel Controller → Service → Repository → Eloquent / DTO |
| **Frontend** | TypeScript。表示判断は `lib/task`、Presentation は `features/task` |
| **API** | list / detail / create / update / delete |
| **一覧** | `TaskQuick` |
| **詳細** | `TaskDetail` |
| **Flow** | `TASK_CRUD` |
| **SIT** | `TASK_CRUD-SYS-001`〜`004`, `101`〜`102` |
| **FE** | `TASK_CRUD-FE-001`〜`004` |
| **認証** | サンプル Scope 外 |
| **監査** | 認証済み会員 mutation 自体が Scope 外のため N/A |

---

## 質問（回答は A/B/C… の ID で返信可）

### 削除・データ

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| D1 | **Task 削除の意味** | **A)** hard delete / **B)** soft delete |
| D2 | **削除履歴・復元** | **A)** 今回は持たない / **B)** 履歴・復元まで含める |

| ID | 回答 | 理由 |
|----|------|------|
| D1 | **A** | 最小 CRUD の責務に限定する |
| D2 | **A** | soft delete / audit history は Scope を広げるため |

### Validation / API

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| V1 | **title 制約** | **A)** non-empty のみ / **B)** trim 後 1〜200 文字 |
| V2 | **description** | **A)** nullable / max 2000 / **B)** required |
| V3 | **not found** | **A)** 404 / **B)** 200 + null body |

| ID | 回答 | 理由 |
|----|------|------|
| V1 | **B** | Validation / DB 契約を明示できる |
| V2 | **A** | Task の最小入力は title のみでよい |
| V3 | **A** | REST API の既存契約として自然 |

### Read model

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| R1 | **list / detail response** | **A)** 1 DTO 共用 / **B)** Quick / Detail を分離 |
| R2 | **list の description** | **A)** 含める / **B)** 含めない |

| ID | 回答 | 理由 |
|----|------|------|
| R1 | **B** | 一覧と詳細で query / response の責務を分ける |
| R2 | **B** | detail 専用データを list で読まない |

### Frontend / UX

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| U1 | **一覧状態** | **A)** loading / empty / error を区別 / **B)** loading と結果だけ |
| U2 | **詳細導線** | **A)** 一覧選択 → `/tasks/{id}/` / **B)** modal のみ |
| U3 | **mutation UI** | **A)** 今回含める / **B)** API のみで UI は Scope 外 |

| ID | 回答 | 理由 |
|----|------|------|
| U1 | **A** | FE Flow Contract の最小例になる |
| U2 | **A** | route continuity を FE-ID で示せる |
| U3 | **B** | サンプルを list/detail + API CRUD に限定する |

### 認証・監査

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| A1 | **認証** | **A)** 含める / **B)** Scope 外 |
| A2 | **会員監査** | **A)** created_by 等を入れる / **B)** 認証 Scope 外に合わせ N/A |

| ID | 回答 | 理由 |
|----|------|------|
| A1 | **B** | Human-on-Exception の開発フロー例に不要 |
| A2 | **B** | [audit-ui-persistence.md](../../rules/audit-ui-persistence.md) の適用対象外 |

### テスト・docs・Issue

| ID | 質問 | 選択肢（案） |
|----|------|----------------|
| T1 | **SIT** | **A)** CRUD 正系 + validation/not-found 逆系 / **B)** Feature test のみ |
| T2 | **FE Contract** | **A)** loading / empty / error / detail path / **B)** integration のみ |
| T3 | **4 点セット** | **A)** flow/ui/validation/db 全て / **B)** flow のみ |
| T4 | **Issue / PR 分割** | **A)** Backend と Frontend を子 Issue に分割 / **B)** 1 Issue 1 PR で全部 |

| ID | 回答 | 理由 |
|----|------|------|
| T1 | **A** | API / DB 状態の縦串を示す |
| T2 | **A** | Paw と同じ pure contract + 代表 integration |
| T3 | **A** | docs-follow の正本どおり |
| T4 | **A** | Backend 完了後に Frontend を接続でき、review 単位も明確 |

---

## 確定事項（実装）

| 項目 | 内容 |
|------|------|
| 削除 | hard delete |
| title | trim 後 1〜200 |
| description | nullable / max 2000 |
| list | `TaskQuick` |
| detail | `TaskDetail` |
| route | list → `/tasks/{id}/` |
| mutation UI | Scope 外 |
| 認証 / 会員監査 | N/A |
| Backend | Controller → Service → Repository → Model / DTO |
| Frontend | api → lib → hooks → features |
| SIT | SYS-001〜004 / 101〜102 |
| FE | FE-001〜004 |

---

## Issue 分割（起票案）

| 順 | タイトル（案） | Pack / Flow | 依存 |
|----|----------------|-------------|------|
| 1 | `feat: Task CRUD backend` | `task-crud` / `TASK_CRUD` | なし |
| 2 | `feat: Task CRUD frontend list/detail` | `task-crud` / `TASK_CRUD` | **1 完了後** |

**マージ順（推奨）**: Backend → Frontend。

---

## 回答後に AI が行うこと

1. 本ファイルへ回答・確定事項を反映
2. 追加不明点があれば Questions を追加
3. 不明点が無ければ GitHub Issue 起票
4. Pack / Flow ID / 触ってよいパス / 完了 make を Issue に記載
5. Issue に沿って実装・test・4 点セット docs を更新
6. PR 作成後は別人格 AI review → 実装 AI が指摘を判定

---

## 完了 `make`

```bash
make lint
make test
make survey
```

---

## 関連

- flow: [タスクCRUD.md](../../flow/タスクCRUD.md)
- ui: [タスクCRUD.md](../../ui/タスクCRUD.md)
- validation: [タスクCRUD.md](../../validation/タスクCRUD.md)
- db: [タスクCRUD.md](../../db/タスクCRUD.md)
- pack: [task-crud.md](../../ai/packs/task-crud.md)
