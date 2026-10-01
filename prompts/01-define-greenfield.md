# 1B. Define Questions for greenfield / ゼロプロから Questions 作成

## English

<What you want to build / purpose / attached material>

Follow `AGENTS.md`, `docs/rules/ai-workflow.md` §2, and `docs/rules/domain-decisions.md` in **greenfield mode**.

Greenfield mode applies when the target product/feature has no implementation, tests, feature docs, concept, or accepted decision that defines current behavior. Do not fabricate current facts and do not pretend repository exploration discovered a contract that does not exist. Record the absence of an existing target contract as a fact.

Start from the human intent, repository-wide rules, technical constraints, and any attached material. Produce a provisional design model only far enough to expose semantic decisions. AI owns ordinary technical structure and implementation choices that are already delegated by repository rules; humans own purpose, semantic boundaries, scope, and risk acceptance.

Before creating Questions, consider every investigation dimension required by `docs/rules/ai-workflow.md`: intent/boundary, concepts/meaning, actors, unit separation, input/uniqueness, create/update, UX continuity, failure, evidence/safety, cross-cutting concerns, and verification. For each dimension, either propose a rule-compliant default, identify a semantic ambiguity, or record a reasoned N/A.

Do not ask the human to choose framework structure, file placement, ordinary layering, test organization, password hashing, transaction mechanics, or similar implementation details when repository rules already delegate them to AI.

Create Questions only where two or more materially different product meanings remain possible, where irreversible/destructive behavior needs authorization, where security/privacy/cost risk acceptance is required, or where repository rules cannot resolve a conflict.

Use `docs/templates/questions.md`. In Current facts, explicitly separate:
- facts supplied by the human or repository-wide rules
- facts that no target implementation/contract exists yet
- AI technical decisions / provisional design assumptions

For each Question, include concrete examples, option impact, recommendation + reason, blocked scope, and what will resume after the answer. Never promote a recommendation or conventional product pattern into an accepted answer.

When a confirmed record refers to mutable master data, mappings, membership, roles, or other changeable relationships, verify the time semantics explicitly: whether later changes affect only future operations or also reinterpret existing confirmed records. If product meaning cannot determine prospective vs retroactive behavior, raise a Question instead of leaving it to implementation.

If no semantic blocker exists, zero Questions is valid. In that case, record the proposed concept / Pack / Flow / path structure as AI-owned design work and proceed only within the permissions of the next authorized stage.

This investigation is not necessarily one-shot. After Prompt 2 applies human answers, re-enter the affected investigation dimensions whenever an answer introduces or changes product meaning. Examples include a new record kind, a new actor, a newly required field, or a concept whose meaning no longer fits the accepted answer. If those consequences admit multiple materially different meanings or require risk acceptance, create follow-up Questions instead of silently extending the provisional model. Continue the 1 ↔ 2 loop until no human-authority blocker remains.

## 日本語

<やりたいこと / 目的 / 添付資料>

`AGENTS.md`、`docs/rules/ai-workflow.md` §2、`docs/rules/domain-decisions.md` に従い、**greenfield mode** で進めること。

greenfield mode は、対象プロダクト・対象機能について現行挙動を定義する実装・テスト・feature docs・concept・Accepted decision が存在しない場合に使う。存在しない current facts を創作せず、「探索した結果、契約が見つかった」ことにもしない。対象の既存契約が無いこと自体を事実として記録すること。

人間の Intent、repo 全体ルール、技術制約、添付資料を起点に、意味の判断点を露出させるために必要な範囲だけ暫定設計を作る。repo ルールで委譲済みの通常の技術構造・実装判断は AI が所有し、目的・semantic boundary・Scope・Risk acceptance は人間が所有する。

Questions を作る前に、`docs/rules/ai-workflow.md` が要求する全 investigation dimension――Intent / boundary、Concepts / meaning、Actors、Unit separation、Input / uniqueness、Create / update、UX continuity、Failure、Evidence / safety、Cross-cutting、Verification――を検討すること。各観点について、ルール準拠のデフォルト案を出す、意味の曖昧さを特定する、または理由付き N/A を記録すること。

repo ルールですでに AI に委譲されている framework 構造、ファイル配置、通常の layer 分割、test 構成、password hash、transaction mechanics などを人間に選ばせないこと。

人間へ Question を返すのは、複数の意味が実質的に成立する場合、不可逆・破壊的な挙動に許可が要る場合、security/privacy/cost の risk acceptance が必要な場合、または repo ルール同士の衝突を AI が解消できない場合だけにすること。

`docs/templates/questions.md` を使うこと。Current facts では次を明確に分けること。
- 人間の依頼や repo 全体ルールから確定している事実
- 対象の実装・契約がまだ存在しないという事実
- AI technical decisions / 暫定設計上の仮定

各 Question に具体例、選択肢の影響、推奨＋理由、止まる範囲、回答後に再開する内容を付けること。推奨や一般的なプロダクト慣習を Accepted answer に昇格しないこと。

確定記録が、後から変更できるマスター、mapping、membership、role その他の可変な関係を参照する場合は、時間方向の意味を明示的に確認すること。後の変更が将来の操作だけに効くのか、既存の確定記録まで再解釈するのかを区別し、product meaning から決まらない場合は実装へ委ねず Question にすること。

意味の blocker が無ければ Questions 0 件でもよい。その場合は concept / Pack / Flow / path structure の提案を AI-owned design work として記録し、次に許可された工程の範囲だけ進めること。

この調査は一度きりとは限らない。Prompt 2 で人間の回答を反映した結果 product meaning が新設・変更された場合は、影響を受けた investigation dimension を再度通すこと。たとえば新しい記録種別、新しい actor、新しく必須になった項目、Accepted answer と整合しなくなった既存概念などである。その帰結に複数の実質的な意味が成立する、または risk acceptance が必要なら、暫定モデルへ黙って押し込まず follow-up Question を作ること。human-authority blocker が 0 件になるまで 1 ↔ 2 のループを続けること。
