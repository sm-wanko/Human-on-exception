# 4. PR 指摘対応

PR #<number> の指摘に対応すること。

AGENTS.md と docs/rules/ai-review.md に従い、全指摘を valid / false positive / decision required に分類すること。
意味に関わる指摘はconcept・ADR・Policyと照合し、構造の複雑さだけで合意済みの区別や不変条件を削らないこと。
妥当なら修正・回帰テスト・docs・検証を行い、根拠と commit を返信して解決すること。false positive は合意契約・実装・テストの根拠を示すこと。
最新差分の独立 AI 再レビューと必須チェックを確認し、未実施は pending とすること。通常の修正を人間へ戻さず、AI に決定権がない事項だけ Questions へ戻すこと。
