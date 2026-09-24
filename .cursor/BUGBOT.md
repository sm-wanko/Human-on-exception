# Bugbot（Human-on-Exception）

PR diff レビュー用。IDE Agent 用の `.cursor/rules/*.mdc` とは別系統。
[独立 AI レビュー契約](../docs/rules/ai-review.md) を適用し、実装者とは別コンテキストで AC / diff / test を評価する。
コメントは日本語。実装提案より **バグ・セキュリティ・仕様逸脱・回帰リスク** を優先する。
スタイルのみ・推測での称賛・変更意図の推測はしない。問題が無ければ簡潔に。

共有の正本（必要時のみ参照）:

- [AGENTS.md](../AGENTS.md)
- [.github/copilot-instructions.md](../.github/copilot-instructions.md)

---

## 指摘してよいこと

- 実バグ・回帰・データ破壊・権限漏れ・認証/CORS の危険な緩和
- 依頼範囲外の API 仕様変更・ビジネスロジック変更・レイヤー破壊
- 会員向け mutation の監査抜け
- テスト欠落が動作リスクに直結する場合

## 指摘しなくてよいこと（false positive 抑制）

- migration / seed / fixture 由来行の監査列が会員 UI 経路と同じでないこと
- schema に監査列が無い table へ audit migration が無いこと
- flow で N/A とした境界が「未完成」であること
- docs のみを根拠にした「実装が docs と違うので実装を直せ」（SoT: implementation → system test → flow）
- lint/format だけの差分、純粋なコメント・docs 文言整理（リスクが無い限り）

---

## Backend: 会員向け mutation の監査（ブロッカー寄り）

`apps/backend/app/**` で認証済み UI/API からの登録・更新・削除相当を追加・変更している場合は、[docs/rules/audit-ui-persistence.md](../docs/rules/audit-ui-persistence.md) の MUST を適用する。

---

## 変更範囲のガードレール

依頼・PR 説明に無い限り、次は高優先で指摘する:

- API パラメータ / レスポンス形の変更
- 認証・CORS・セキュリティ設定の削除や緩和
- route / bootstrap へのビジネスロジック追加
- レイヤー責務の跨ぎ（Controller が DB、Repository が HTTP 等）

---

## コメントの書き方

各指摘に次を含める:

1. 何が問題か（1〜2 文）
2. 影響範囲（誰・どのデータ・どの経路）
3. 再現または確認手順（分かれば）
4. 望ましい修正の方向（コード丸ごと書き換え提案は控えめに）
