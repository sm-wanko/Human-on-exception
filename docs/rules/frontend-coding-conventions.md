# Frontend コーディング規約（詳細・索引）

> **AI（Cursor / Claude Code / CodeX）**: 毎回読む正本は **[frontend-quick.md](./frontend-quick.md)**。  
> 本ファイルは **コード例・手順の深掘り**用。MUST / レイヤ責務 / lib 正本の正本は quick に集約済み。

**適用範囲**: `apps/frontend/` のみ。

---

## quick との対応

| トピック | 正本 |
|----------|------|
| MUST NOT・完了 | [frontend-quick.md §1, §10](./frontend-quick.md) |
| レイヤ・lib/hooks 境界 | [§2, §3](./frontend-quick.md) |
| 配置 | [§4](./frontend-quick.md) |
| API・types・命名 | [§5–6](./frontend-quick.md) |
| **JSDoc** | quick §7 + 本ファイル §コメント |
| 画面遷移 | quick §9 + 本ファイル §画面遷移 |
| テスト・Flow Contract | quick §10 + [frontend-flow-contract.md](../testing/frontend-flow-contract.md) |

---

## プロジェクト構成（参照用）

```
apps/frontend/src/
├── app/
├── api/
├── lib/<domain>/
├── features/<domain>/
├── components/
├── hooks/<domain>/
├── types/
└── utils/
```

---

## API：request

```typescript
export async function request<T>(url: string, options?: RequestInit): Promise<T> {
  const response = await fetch(url, options)
  if (!response.ok) throw new Error(`HTTP ${response.status}`)
  return response.json() as Promise<T>
}
```

通信は api 層、意味付けは lib。

---

## lib 内サブ分割例

`lib/task/` — `buildTaskListViewModel`, `resolveTaskDetailState` 等の純関数。

### hooks 分割例

- `useTaskListQuery` — 取得 + lib 呼び出し
- `useTaskActions` — 遷移・mutation
- Presentation は hook の結果を描画するだけ

---

## コメント（JSDoc）詳細

quick §7 が正本。触った exported は同一 PR で付与。

```typescript
/** 一覧表示用 Task view model を生成する */
export function buildTaskListViewModel(tasks: TaskQuick[]): TaskListViewModel {
  // ...
}
```

---

## 画面遷移ドキュメント

route / Link / navigate 変更時は **同一 PR** で:

1. `docs/transition/遷移定義.md`
2. `make docs`
3. `make survey`

---

## 自動反復レビュー（AI 作業手順）

1. 現状レビュー → 2. 修正 → 3. 再レビュー → 4. 禁止違反ゼロまで繰り返し

**完了条件**: 禁止違反なし／未対応項目を明示／影響範囲を説明できる／テスト追加または既存で担保
