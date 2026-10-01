# 1. Define Questions / Questions 作成

Choose the entry that matches the target.

- [1A. Existing repository / 既存 repo](./01-define-existing.md) — the target already has implementation, tests, docs, or accepted contracts to investigate.
- [1B. Greenfield / ゼロプロ](./01-define-greenfield.md) — the target has no implementation or accepted feature contract yet.

If it is unclear which mode applies, inspect only enough to determine whether a current target contract exists. Do not ask the human to choose a mode when the repository can determine it.

Prompts 1 and 2 form a decision loop, not a one-pass sequence. After answers are applied in Prompt 2, any newly introduced or changed product meaning must be reinvestigated. If that reveals another human-authority Question, return to the Questions/Answers loop. Create implementation Issues only after no such blockers remain.

## 日本語

対象に合う入口を使うこと。

- [1A. Existing repository / 既存 repo](./01-define-existing.md) — 対象に実装・テスト・docs・Accepted contract があり、現状調査から始める。
- [1B. Greenfield / ゼロプロ](./01-define-greenfield.md) — 対象の実装・Accepted feature contract がまだ無く、Intent と repo ルールから設計仮説を作る。

どちらか不明な場合は、current target contract の有無を判定するために必要な範囲だけ調査すること。repo から判定できるモード選択を人間に質問しないこと。

Prompt 1 と 2 は一方向の手順ではなく、意思決定が収束するまでのループである。Prompt 2 で回答を反映した結果、新しい product meaning や semantic boundary が生まれたり変わったりした場合は、その影響を再調査すること。そこで新しい human-authority Question が見つかれば Questions / Answers のループへ戻る。実装 Issue は、その種の blocker が 0 件になってから起票すること。
