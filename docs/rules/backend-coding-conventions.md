# Backend コーディング規約（詳細・索引）

> **AI（Cursor / Claude Code / CodeX）**: 毎回読む正本は **[backend-quick.md](./backend-quick.md)**。  
> 本ファイルは **コード例・手順の深掘り**用。MUST / 禁止 / レイヤ責務の正本は quick に集約済み（ここに重複記載しない）。

**適用範囲**: `apps/backend/` のみ。

---

## quick との対応

| トピック | 正本 |
|----------|------|
| MUST NOT・完了 | [backend-quick.md §1, §10](./backend-quick.md) |
| レイヤ責務・配置 | [§2, §3](./backend-quick.md) |
| エラー・DB要約・ログ・命名 | [§4–7, §9](./backend-quick.md) |
| **Tx 境界・migration 詳細** | **本ファイル §Tx / §マイグレーション** |
| **PHPDoc** | quick §8 + **本ファイル §コメント** |
| テスト | quick §10 + **本ファイル §テスト** |

---

## プロジェクト構成（参照用）

```
apps/backend/
├── app/
│   ├── Http/Controllers/      # handler 相当
│   ├── Http/Requests/         # HTTP validation
│   ├── Http/Resources/        # API response
│   ├── Services/              # business / orchestration
│   ├── Repositories/          # persistence
│   ├── DTO/                   # Quick / Detail 等
│   └── Models/
├── database/migrations/
├── routes/
└── tests/
    ├── Unit/
    ├── Feature/
    └── System/
```

---

## Controller 実装例

```php
public function show(int $task, TaskService $service): JsonResponse
{
    $detail = $service->getDetail($task);

    return response()->json($detail->toArray());
}
```

Controller は bind / status / response mapping のみ。

---

## Service：エラー正規化例

```php
public function getDetail(int $id): TaskDetail
{
    $task = $this->tasks->findDetail($id);

    if ($task === null) {
        throw new TaskNotFoundException($id);
    }

    return $task;
}
```

---

## Repository：Query 例

```php
public function listQuick(): array
{
    return Task::query()
        ->select(['id', 'title'])
        ->orderBy('id')
        ->get()
        ->map(fn (Task $task) => new TaskQuick($task->id, $task->title))
        ->all();
}
```

---

## Tx 境界

- **単一 Repository・単一 write**: Repository 内で完結してよい
- **複数 Repository / 複数 write の原子性が必要**: Service が `DB::transaction` でオーケストレーション
- 外部 HTTP / Queue 等の非 DB 副作用を DB rollback 可能と誤認しない。必要なら outbox / after-commit 等を設計する

## Query（ユースケース単位の哲学）

- 一覧用と詳細用で読む列・relation が違うなら **query を分ける**
- 巨大な万能 query / flag 地獄を避ける
- binding・N+1 回避を維持
- Quick / Detail を無理に 1 DTO にまとめない

---

## コメント（PHPDoc）詳細

quick §8 が正本。補足のみ。

| 種別 | ルール |
|------|--------|
| public class/method | 非自明な入出力・副作用・権限 |
| 複雑な public | 2〜4 行程度 |
| 触った public | 同一 PR で不足を補う |
| 禁止 | 仕様全文コピー、docs メタだけのコメント |

---

## マイグレーション

| コマンド | 用途 |
|----------|------|
| `php artisan migrate` | 最新まで適用 |
| `php artisan migrate:rollback` | ロールバック |
| `php artisan make:migration ...` | 新規作成 |

- Laravel migration を正本とする
- destructive change は既存データ・rollout を確認
- seed / fixture は migration と混ぜない

---

## テスト（詳細）

| コマンド | 対象 |
|----------|------|
| `make test` | PHPUnit Feature / Unit |
| `php artisan test` | Laravel test |

SIT は [system-test-strategy.md](./system-test-strategy.md)。

---

## 自動反復レビュー（AI 作業手順）

1. 現状レビュー → 2. 修正 → 3. 再レビュー → 4. MUST 違反ゼロまで繰り返し

**完了条件**: MUST 違反なし／未対応項目を明示／影響範囲を説明できる／テスト追加または既存で担保
