# 束（pack）完了の定義

`docs/testing/core-features.md` の各束を Done にするときの共通ルール。**テスト Gap A = 0 だけでは Done にしない。**

## 完了順

1. **docs** — 4 点セット・flow マトリクス・束境界（不足なら先に追記）
2. **pack** — `docs/ai/packs/<bundle>.md`（チェックリスト・パス索引）
3. **テスト** — `make fe-survey` / 代表 integration / SIT（flow に SYS がある場合）
4. **Issue Done** — チェックリスト全 [x]

## チェックリスト（各束で pack 内にコピー）

### ドキュメント

- [ ] 4 点セット（flow / ui / validation / db）または N/A 明示
- [ ] flow Scope と束境界
- [ ] flow の FE / SYS マトリクスが実装と矛盾しない

### pack

- [ ] `docs/ai/packs/<bundle>.md` あり（flow 本文はコピーしない）
- [ ] 完了 `make`・禁止を記載

### テスト

- [ ] 当該 `*-FE-*` の Gap A = 0（`make fe-survey`）
- [ ] 代表 integration（resolver 導線がある束）
- [ ] 当該 `*-SYS-*` SIT（Backend 縦串がある場合）

## 関連

- [core-features.md](./core-features.md)
- [frontend-flow-contract.md](./frontend-flow-contract.md)
