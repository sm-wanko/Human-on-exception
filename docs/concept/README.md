# Product Concept / プロダクト概念

## English

This is the human-readable entrypoint for purpose, users, core concepts, success conditions, and non-goals.

Procedures/API/SQL belong in the 4-point docs. Durable design reasons belong in ADR. Repeatable decision criteria belong in Policy. Follow [domain-decisions](../rules/domain-decisions.md).

| Target | Material | Role |
|---|---|---|
| Development repository | [README](../../README.md) / [AI execution contract](../rules/ai-workflow.md) | humans decide intent/boundaries; AI owns execution |
| Task CRUD | [task-crud.md](./task-crud.md) | minimal teaching example describing current implementation |

For a new product, AI drafts the following. Unresolved meaning goes to Questions and must not be treated as accepted before the human answer:

1. Whose problem is being solved, and what problem is it?
2. What must users be able to do for the product to succeed? What is explicitly out of scope now?
3. Terminology, actor roles, the unit of one record/experience, fact vs candidate/reference, aggregation, uniqueness, and display meaning.
4. Representative examples and similar-looking counterexamples that must remain outside the concept.
5. Links to the relevant Pack / Flow / ADR / Policy.

Do not automatically adopt constraints from the sample as requirements for a new product.

## 日本語

目的・利用者・主要概念・成功条件・非対象を人間が理解できる言葉で説明する入口。

手順・API・SQL は4点セット、有効な設計理由は ADR、反復判断は Policy を参照する。[意味と判断の継承規約](../rules/domain-decisions.md) に従う。

| 対象 | 資料 | 位置付け |
|---|---|---|
| 開発リポジトリ | [README](../../README.md) / [AI実行契約](../rules/ai-workflow.md) | 人間が目的と境界を決め、AIが実行を担う |
| Task CRUD | [task-crud.md](./task-crud.md) | 既存実装を説明する最小教材 |

新しいプロダクトでは AI が次を具体化する。未決は Questions に分離し、人間の回答前に確定扱いしない。

1. 誰の、どんな困りごとを解決するか。
2. 利用者が何をできれば成功か。今回は何をしないか。
3. 用語、主体の役割、1件の単位、事実と候補/参考、集約・一意性・表示の意味。
4. 代表例と、似ているが対象外になる反例。
5. 関係する Pack / Flow / ADR / Policy へのリンク。

サンプルの業務上の制約を、新しいプロダクトの要求として自動採用しない。

Language selection / translation / 言語選択・翻訳: [language-policy](../rules/language-policy.md).
