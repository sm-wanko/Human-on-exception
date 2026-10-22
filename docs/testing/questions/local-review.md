# 横断リポジトリのローカルレビュー — Questions

**Status**: Ready  
**Pack / Flow ID**: なし。ワークフロー契約  
**Investigation revision**: `be99545`（採用時点の `main`）  
**Related**: [ai-review.md](../../rules/ai-review.md) / Issue #25

## Goal / Scope

- 1つの PR から見られない複数リポジトリの照合に、指摘と返信の証跡を残す。
- プロダクトの意味は変えない。

## 採用（2026-10-19）

人の採用: 任意の `04-local-review` を置き、記録は `docs/reviews/<Flow ID>/` の 1 回 1 ファイルにする。ファイル名は日付と短縮 commit とし、PR 番号は本文の先頭に書く。過去のファイルをまとめて読まない。各リポジトリの `@codex review` は残し、横断照合の代わりにしない。

未決の Question は 0 件。手順の正本は `docs/rules/ai-review.md` に置く。
