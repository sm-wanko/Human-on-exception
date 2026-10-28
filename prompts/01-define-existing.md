# 1A. Define Questions from an existing repository / 既存 repo から Questions 作成

## English

<What you want to build / purpose / attached material>

The text in that slot is the requested change. Investigate it against the accepted contract, assumptions, and any recorded follow-up condition. If it conflicts with them and the conflict is a meaning only a human can close, open Questions for that conflict. Do not finish by only comparing the old answers to the current implementation.

Follow `AGENTS.md` and `docs/rules/ai-workflow.md` §2 in **existing-contract mode**. Investigate repository facts yourself before asking the human.

Use the current-state Source of Truth order. Read only the relevant feature bundle and trace implementation, system tests, flow/UI/validation/DB docs, concept, active ADR, and Policy as needed. Reconstruct missing current contracts from implementation and tests rather than asking the human to explain code that the repository can reveal.

Following `docs/rules/domain-decisions.md`, understand purpose, concepts, units, evidence meaning, accepted examples, and counterexamples. Do not infer purpose from implementation size or a familiar product category. Distinguish authentication actor, operating actor, owner/manager, experience/record subject, and search/decision actor. Do not assume that one bulk UI operation equals one persisted/editable/unique domain record.

Use `docs/templates/questions.md` to organize Goal / Scope candidates / current facts / Risks / Unknowns / Assumptions, and create only the questions that require human decision authority under `docs/testing/questions/`.

For each Question, include evidence, concrete examples, impact of options, and a recommendation with reason. Phrase it so the human can answer without reading code. Do not ask about implementation detail already determined by rules or repository investigation. Never treat a recommendation as an accepted answer.

When a confirmed record refers to mutable master data, mappings, membership, roles, or other changeable relationships, verify the time semantics explicitly: whether later changes affect only future operations or also reinterpret existing confirmed records. If product meaning cannot determine prospective vs retroactive behavior, raise a Question instead of leaving it to implementation.

If the repository lacks documentation for behavior that clearly exists in implementation/tests, treat that as an AI-owned reconstruction task. Do not convert missing docs into a human question unless the missing information is semantic and cannot be recovered from current behavior or accepted decisions.

Before the human is asked to answer, the implementing context launches a separate-context review under `docs/rules/ai-review.md`. A self-review does not count. The review checks current-behavior facts and the grounds of each Question: the concrete example matches the code or an accepted decision, the reason human authority is required is not already settled by that code or decision, and the blocked scope follows from those facts. It does not choose an option, and it does not treat the recommendation as an answer. A claim the repository cannot settle stays under Risks / Unknowns / Assumptions. Apply valid findings to the Questions. The separate context then reviews only that appended range. The human may answer when that look reports no unresolved valid or unclassified finding. Do not keep iterating to prove that every factual error is absent. When there are zero Questions, run the same review on the recorded facts and on the claim that no human-authority question remains. Zero Questions is valid only after the requested change was investigated. Still write the Questions file: the request, the current contract it uses, the AI-owned way that request is realized, and the claim that no human question remains. When Questions exist, Prompt 2 starts only after the answers and after that look is clear. When there are zero Questions, Prompt 2 starts after that look is clear, without waiting for answers. Tell the human to run Prompt 2. The same review applies to follow-up Questions before they are returned to the human.

This investigation may be re-entered after Prompt 2. An accepted answer can introduce a new concept, split an existing meaning, change required fields, or make a previous assumption invalid. Re-run only the affected investigation dimensions and create new Questions when those consequences require human authority. Do not assume that answering the original Questions proves the target contract is complete.

## 日本語

<やりたいこと / 目的 / 添付資料>

その欄の文が、依頼された変更である。受諾した契約、Assumptions、記録された follow-up 条件と照合すること。それらと食い違い、その食い違いを閉じられるのが人間だけなら、その食い違いの Questions を作ること。昔の回答と今の実装を比べただけで終わらないこと。

`AGENTS.md` と `docs/rules/ai-workflow.md` §2 の **existing-contract mode** に従い、人間へ質問する前に repo の事実を自力で調査すること。

current-state の Source of Truth 順に従い、関係する feature bundle だけを読み、必要に応じて実装・system test・flow/UI/validation/DB docs・concept・active ADR・Policy を追うこと。repo から分かるコード事実を人間に説明させず、欠けた現状契約は実装とテストから再構成すること。

`docs/rules/domain-decisions.md` に沿って、目的、概念・単位・根拠の意味、許容例と反例を理解すること。実装量や既知カテゴリから目的を逆推定せず、認証主体・操作主体・所有/管理主体・体験/記録主体・検索/判断主体を分離して確認すること。UI の一括操作と保存・編集・一意性の単位が同じとは仮定しないこと。

`docs/templates/questions.md` を使い、Goal / Scope 候補 / current facts / Risks / Unknowns / Assumptions を整理し、人間の意思決定が必要な質問だけ `docs/testing/questions/` に作成すること。

各質問に根拠・具体例・選択肢の影響・推奨理由を付け、コードを読まずに回答できるようにすること。規約や repo 調査で決まる実装詳細は質問しないこと。推奨を回答済みにしないこと。

確定記録が、後から変更できるマスター、mapping、membership、role その他の可変な関係を参照する場合は、時間方向の意味を明示的に確認すること。後の変更が将来の操作だけに効くのか、既存の確定記録まで再解釈するのかを区別し、product meaning から決まらない場合は実装へ委ねず Question にすること。

実装やテストに存在する振る舞いの docs が欠けているだけなら、それは AI が再構成する作業として扱うこと。現状挙動や合意済み判断から復元できず、意味そのものが未確定な場合だけ人間への Question にすること。

人間が答える前に、実装側のコンテキストが `docs/rules/ai-review.md` に従って別コンテキストのレビューを起動する。実装側の自己レビューは数えない。照合するのは、現行挙動として書いた事実と、各質問の根拠である。具体例がコードまたは受け入れ済みの決定と一致すること、人間の権限が要る理由がそれらで既に決まっていないこと、止まると書いた範囲がそれらの事実から続くこと。選択肢は選ばない。推奨を回答にしない。リポジトリから決まらない主張は、Risks / Unknowns / Assumptions に残す。妥当な指摘は Questions に足す。別コンテキストは、その足した範囲だけを見る。その一見に未解決の妥当な指摘も未分類の指摘も無いとき、人間は答えてよい。事実の誤りがすべて無いと証明できるまで続けない。Questions が 0 件のときも、記録した事実と、人間の権限が要る質問が残っていないという主張に、同じ照合を行う。0 件が有効なのは、依頼された変更を調べたあとだけである。0 件でも Questions ファイルは書く。依頼、頼る現在の契約、AI が持つ実現方法、人間の質問が残っていないという主張を残す。質問があるときは、Prompt 2 は回答のあと、かつその一見が済んでから始める。0 件のときは、回答を待たず、その一見が済んだら Prompt 2 を始める。人間に Prompt 2 を実行するよう伝える。follow-up Questions も、人間へ返す前に同じ照合を行う。

この調査は Prompt 2 の回答反映後にも再実行されうる。Accepted answer により新しい概念が生まれる、既存の意味が分割される、必須項目が変わる、以前の仮定が無効になる場合がある。そのときは影響を受けた investigation dimension だけ再調査し、人間の判断権限が必要な帰結を新しい Question として起こすこと。元の Questions がすべて回答済みであることを、target contract が完全である証拠にしてはならない。
