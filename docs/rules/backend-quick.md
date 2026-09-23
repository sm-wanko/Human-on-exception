# Backend Quick Rules（AI 常時）

**適用**: `apps/backend/` のみ。  
**AI**: 本ファイルを正本とする。詳細・例・背景は [backend-coding-conventions.md](./backend-coding-conventions.md)（索引）のみ必要時。

| 状況 | 読むもの |
|------|----------|
| BE 実装・修正（毎回） | **本ファイル** |
| Tx / migration / PHPDoc / middleware | [backend-coding-conventions.md](./backend-coding-conventions.md) |
| なぜ・背景 | 同上（人間向け） |

---

## 1. MUST NOT（壊すとアーキ崩壊）

- Controller にビジネスロジック（分岐・正規化の判断は Service）
- Service が Eloquent / DB facade を直接触る（必ず Repository）
- Repository にビジネス判断
- Controller 内で Service / Repository を new（コンストラクタ注入）
- `bootstrap/` / route 定義にロジック（配線のみ）
- SQL 文字列連結（Query Builder / binding を使う）
- 外部 API で timeout 省略
- timeout 値のハードコード（config から）
- 「関連だから」別ドメインの Service / Repository に配置（**所属**で置く）
- エラーを無視する
- docs のみを根拠に既存実装・テストを削除（SoT: 実装 → test → flow）

---

## 2. レイヤ責務（正本はこの表のみ）

| 層 | MUST | MUST NOT |
|----|------|----------|
| **Controller** | bind・認証引継ぎ・HTTP status / Resource 返却 | ビジネスロジック・DB |
| **Service** | ルール・オーケストレーション・例外正規化 | Eloquent / 生 SQL・HTTP Response |
| **Repository** | Query Builder / Eloquent・永続化 | ビジネス判断・HTTP |
| **DTO / Resource** | API DTO / read model | DB 更新・ドメイン判断 |
| **Model** | DB / ドメインモデル | API 専用レスポンス組立 |
| **FormRequest** | HTTP 入力バリデーション | ビジネス判断 |

**流れ**: `Request → Controller → Service → Repository → Model`（API DTO / read model は DTO / Resource）

---

## 3. 配置（所属ベース）

- `app/Http/Controllers/{Domain}`
- `app/Services/{Domain}`
- `app/Repositories/{Domain}`
- `app/Models`
- `app/DTO/{Domain}` / `app/Http/Resources/{Domain}`
- `app/Http/Requests/{Domain}`
- Repository 分割は **1 テーブル = 1 class に固定しない**。変更理由が同じ単位でまとめる
- 肥大化したら責務別 class / file に分割

---

## 4. エラー

- Repository: DB / framework 例外をそのまま UI に漏らさない
- **Service: アプリケーション例外へ正規化**して Controller へ
- Controller: status / response mapping のみ
- not found / conflict 等の意味付けは Service が担当

---

## 5. DB・SQL・監査

- **Query**: ユースケース単位。一覧用と詳細用で列・JOIN が違うなら分ける
- **Tx**: 単一 Repository の単純 write は Repository 内で完結可。複数 Repository / 複数 write を同一境界に束ねる場合は Service が `DB::transaction` を所有
- **migration**: Laravel migration が schema 変更の正本。既存 migration の意味を後から書き換えず、新規 migration で進める
- **監査**: 会員向け write path は [audit-ui-persistence.md](./audit-ui-persistence.md) を正本

---

## 6. Context・Timeout

- HTTP request の認証・request-id 等は Controller → Service へ必要値だけ渡す
- 外部 API は Laravel HTTP Client 等で timeout を config 注入
- Queue / Job へ渡す値も同じ ownership を維持する

---

## 7. ログ

- Laravel logger / Log facade
- structured context を使う（`action`, `member_id`, `task_id` 等）
- エラーを握り潰さない

---

## 8. コメント（PHPDoc）— 漏れやすいので MUST

- **触った public / exported 相当**の class / method: 非自明な責務・入出力・副作用を PHPDoc で補う
- **禁止**: docs/flow へのメタ参照だけを書く、legacy/Wave 等の doc メタだけを書く
- API 契約の正本は Flow / Validation。コメントへ仕様全文をコピーしない

---

## 9. 命名（最小）

- class: PascalCase · method/property: camelCase · DB / JSON: snake_case
- `XxxService`, `XxxRepository`, `XxxRequest`, `XxxResource`
- Model と API DTO / read model を混同しない

---

## 10. テスト・完了

| 置き場 | 用途 |
|--------|------|
| `tests/Unit/` | ロジック単体 |
| `tests/Feature/` | HTTP + Laravel + DB |
| `tests/System/` | 縦串 SIT（[system-test-strategy.md](./system-test-strategy.md)） |

**完了前（BE）**: ルート `make lint` → `cd apps/backend && make test`。構造 / flow 変更時は `make survey`。
