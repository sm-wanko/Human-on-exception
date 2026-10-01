# 4. Resolve PR Review Findings / PR 指摘対応

## English

Handle findings for PR #<number>.

Follow `AGENTS.md` and `docs/rules/ai-review.md`. Classify every finding as `valid`, `false positive`, or `decision required`.

For meaning-related findings, compare against concept / ADR / Policy. Do not remove agreed distinctions or invariants merely because the structure is complex.

For valid findings, fix them and run regression tests, docs updates, and verification. Reply with evidence and commit. For false positives, cite the agreed contract plus implementation/test evidence.

Check independent AI re-review of the latest diff and required checks. If review did not run, keep it pending. Return only true decision exceptions to the human.

## 日本語

PR #<number> の指摘に対応すること。

`AGENTS.md` と `docs/rules/ai-review.md` に従い、全指摘を `valid` / `false positive` / `decision required` に分類すること。

意味に関わる指摘は concept・ADR・Policy と照合し、構造の複雑さだけで合意済みの区別や不変条件を削らないこと。

妥当なら修正・回帰テスト・docs・検証を行い、根拠と commit を返信して解決すること。false positive は合意契約・実装・テストの根拠を示すこと。

最新差分の独立 AI 再レビューと必須チェックを確認し、未実施は pending とすること。通常の修正を人間へ戻さず、AI に決定権がない事項だけ Questions へ戻すこと。
