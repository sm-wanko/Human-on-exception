# 1. Define Questions / Questions 作成

## English

<What you want to build / purpose / attached material>

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §2. Investigate repository facts yourself.

Following `docs/rules/domain-decisions.md`, understand purpose, concepts, units, evidence meaning, accepted examples, and counterexamples from the relevant concept / ADR / Policy.

Do not infer purpose from implementation size or a familiar product category. Distinguish authentication actor, operating actor, experience/record subject, and search/decision actor. Do not assume that one bulk UI operation equals one persisted/editable/unique domain record.

Use `docs/templates/questions.md` to organize Goal / Scope candidates / Risks / Unknowns / Assumptions, and create only the questions that require human decision authority under `docs/testing/questions/`.

For each Question, include evidence, concrete examples, impact of options, and a recommendation with reason. Phrase it so the human can answer without reading code. Do not ask about implementation detail already determined by rules/repository investigation. Never treat a recommendation as an accepted answer.

## 日本語

<やりたいこと / 目的 / 添付資料>

`AGENTS.md` と `docs/rules/ai-workflow.md` §2 に従い、repo の事実を自力で調査すること。

`docs/rules/domain-decisions.md` に沿って、関係する concept・ADR・Policy から目的、概念・単位・根拠の意味、許容例と反例を理解すること。

実装量や既知カテゴリから目的を逆推定せず、認証主体・操作主体・体験/記録主体・検索/判断主体を分離して確認すること。UI の一括操作と保存・編集・一意性の単位が同じとは仮定しないこと。

`docs/templates/questions.md` を使い、Goal / Scope 候補 / Risks / Unknowns / Assumptions を整理し、人間の意思決定が必要な質問だけ `docs/testing/questions/` に作成すること。

各質問に根拠・具体例・選択肢の影響・推奨理由を付け、コードを読まずに回答できるようにすること。規約や調査で決まる実装詳細は質問しないこと。推奨を回答済みにしないこと。
