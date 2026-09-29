# 1A. Define Questions from an existing repository / 既存 repo から Questions 作成

## English

<What you want to build / purpose / attached material>

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §2 in **existing-contract mode**. Investigate repository facts yourself before asking the human.

Use the current-state Source of Truth order. Read only the relevant feature bundle and trace implementation, system tests, flow/UI/validation/DB docs, concept, active ADR, and Policy as needed. Reconstruct missing current contracts from implementation and tests rather than asking the human to explain code that the repository can reveal.

Following `docs/rules/domain-decisions.md`, understand purpose, concepts, units, evidence meaning, accepted examples, and counterexamples. Do not infer purpose from implementation size or a familiar product category. Distinguish authentication actor, operating actor, owner/manager, experience/record subject, and search/decision actor. Do not assume that one bulk UI operation equals one persisted/editable/unique domain record.

Use `docs/templates/questions.md` to organize Goal / Scope candidates / current facts / Risks / Unknowns / Assumptions, and create only the questions that require human decision authority under `docs/testing/questions/`.

For each Question, include evidence, concrete examples, impact of options, and a recommendation with reason. Phrase it so the human can answer without reading code. Do not ask about implementation detail already determined by rules or repository investigation. Never treat a recommendation as an accepted answer.

If the repository lacks documentation for behavior that clearly exists in implementation/tests, treat that as an AI-owned reconstruction task. Do not convert missing docs into a human question unless the missing information is semantic and cannot be recovered from current behavior or accepted decisions.

## 日本語

<やりたいこと / 目的 / 添付資料>

`AGENTS.md` と `docs/rules/ai-workflow.md` §2 の **existing-contract mode** に従い、人間へ質問する前に repo の事実を自力で調査すること。

current-state の Source of Truth 順に従い、関係する feature bundle だけを読み、必要に応じて実装・system test・flow/UI/validation/DB docs・concept・active ADR・Policy を追うこと。repo から分かるコード事実を人間に説明させず、欠けた現状契約は実装とテストから再構成すること。

`docs/rules/domain-decisions.md` に沿って、目的、概念・単位・根拠の意味、許容例と反例を理解すること。実装量や既知カテゴリから目的を逆推定せず、認証主体・操作主体・所有/管理主体・体験/記録主体・検索/判断主体を分離して確認すること。UI の一括操作と保存・編集・一意性の単位が同じとは仮定しないこと。

`docs/templates/questions.md` を使い、Goal / Scope 候補 / current facts / Risks / Unknowns / Assumptions を整理し、人間の意思決定が必要な質問だけ `docs/testing/questions/` に作成すること。

各質問に根拠・具体例・選択肢の影響・推奨理由を付け、コードを読まずに回答できるようにすること。規約や repo 調査で決まる実装詳細は質問しないこと。推奨を回答済みにしないこと。

実装やテストに存在する振る舞いの docs が欠けているだけなら、それは AI が再構成する作業として扱うこと。現状挙動や合意済み判断から復元できず、意味そのものが未確定な場合だけ人間への Question にすること。
