# Frontend Quick Rules（AI 常時）

**適用**: `apps/frontend/` のみ。  
**AI**: 本ファイルを正本とする。詳細・例・背景は [frontend-coding-conventions.md](./frontend-coding-conventions.md)（索引）のみ必要時。

| 状況 | 読むもの |
|------|----------|
| FE 実装・修正（毎回） | **本ファイル** |
| apiClient 例・JSDoc 例・遷移手順 | [frontend-coding-conventions.md](./frontend-coding-conventions.md) |
| Flow Contract | [frontend-flow-contract.md](../testing/frontend-flow-contract.md) |

---

## 1. MUST NOT（壊すとアーキ崩壊）

- **表示意味・ドメイン分岐**を hooks / components / features に書く（正本は **`lib/<domain>`**）
- **`useMemo` / `useCallback` 内**でビジネス `if` や ViewModel を組み立てる（中身は **lib 関数 1 呼び出し**）
- UI が **API レスポンスを直接解釈**して表示状態を決める（`build*` / `resolve*` 経由）
- **同一入力**に対し複数ファイルで別の表示ロジック
- **`features/<domain>/lib/`** を作る（実装は **`src/lib/<domain>/`**）
- **`apiClient` 以外から fetch**
- docs のみを根拠に既存実装・テストを削除（SoT: 実装 → test → flow）

---

## 2. レイヤ責務（正本はこの表のみ）

| 層 | MUST | MUST NOT |
|----|------|----------|
| **app/** | ルート・features import（配線） | ドメインルール・複雑な加工 |
| **api/** | fetch・型・normalize | ViewModel・画面文案 |
| **lib/** | **表示状態・ViewModel の唯一の正本**（純関数） | hooks・JSX・ブラウザ I/O |
| **hooks/** | 状態・副作用・**lib 呼び出し** | ドメイン `if`・構造体組み立て |
| **features/** | ドメイン画面 UI（Presentation） | fetch・ドメイン計算・長い `if` |
| **components/** | 純粋 UI | fetch・ドメイン判断 |
| **types/** | FormValues・フィルタ・ページ状態 | API 生 DTO の単一ソース |
| **utils/** | ドメインを知らない技術 helper | ドメイン判断 |

**流れ**: `api` 取得 → **`lib` で意味付け** → `hooks` が state に載せる → `features` / `components` が描画

---

## 3. lib と hooks の境界（最重要）

- **MUST**: 派生値・表示方針は `lib` の **`buildXxx` / `resolveXxx`**
- **MUST**: hook は lib 関数を呼ぶ。分岐の中身を hook に複製しない
- **許容（hooks）**: loading/null guard、modal 開閉、tab 等 UI state

---

## 4. 配置

```
src/
├── app/                 # 配線
├── api/                 # 通信・型・normalize
├── lib/<domain>/        # 正本
├── features/<domain>/   # Presentation
├── hooks/<domain>/      # 状態・lib 呼び出し
├── components/          # 純粋 UI
├── types/
└── utils/
```

---

## 5. API

- すべて `apiClient.ts` の `request` 経由
- API 層で ViewModel を作らない
- Client は不要な再 fetch を避ける

---

## 6. types・命名（最小）

| 種類 | 置き場所 |
|------|----------|
| API リクエスト/レスポンス | `api/` |
| FormValues・ページ状態 | `types/` |
| ViewModel 生成 | 関数は **`lib/`**、型は `types/` または lib 隣接 |

- Component: PascalCase
- ViewModel: `build*` / `resolve*` / `find*`

---

## 7. コメント（JSDoc）— MUST

- exported func / type / component → 宣言直前に `/** */` 1 行以上
- 同一 PR で触った exported → 欠落を残さない

---

## 8. ESLint / 整形

- TypeScript strict
- Prettier / ESLint は app の設定に従う
- `any` は境界理由が明示できる場合のみ

---

## 9. 画面遷移（route 追加時）

同一 PR で `docs/transition/遷移定義.md` を更新し `make docs` / `make survey`。[docs-follow.md](./docs-follow.md)。

---

## 10. テスト・完了

| 種別 | 置き場 |
|------|--------|
| Flow contract | `lib/<domain>/**/*.contract.test.ts`（FLOW-ID と 1:1） |
| Integration | `*.integration.test.tsx`（代表導線のみ） |
| Vitest | `*.test.ts` / `*.spec.ts` |

**原則**: 分岐は resolver（lib）へ。正本: `docs/flow/<機能>.md` の `*-FE-*`。

**完了前（FE）**: ルート `make lint` → `cd apps/frontend && make test`。詳細は [frontend-coding-conventions.md](./frontend-coding-conventions.md)。
