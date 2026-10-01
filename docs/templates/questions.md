# <Feature / 機能> — Questions

> Bilingual human-facing template. English and Japanese must preserve the same decision-relevant meaning. See [language-policy](../rules/language-policy.md).

**Status / 状態**: Draft / Awaiting answers / Partially decided / Ready / Superseded  
**Pack / Flow ID**: <existing or proposed / 既存または新規案>  
**Investigation revision / 調査 revision**: <SHA>  
**Related / 関連**: <concept / Issue / active ADR / Policy / rules / 4-point docs>

## Goal / Scope

- Problem / success condition — 解決したい問題・成功条件:
- Scope — 今回の Scope:
- Non-goals / required follow-up — Non-goals / 後続必須:
- Contracts to preserve — 維持する契約:

## Current facts / 現状の事実

| Fact / 事実 | Evidence path, symbol, revision / 根拠 | Affected route / 影響経路 |
|---|---|---|
| <investigated fact / 調査済みの事実> | <real reference / 実在する参照> | <UI / API / DB / counterpart> |

## Risks / Unknowns / Assumptions

Investigate concept, units, actors, and evidence meaning through [domain-decisions](../rules/domain-decisions.md). Record applicable criteria, accepted examples, and similar-looking rejected counterexamples. Do not force an unknown concept into a nearby existing concept.

[domain-decisions](../rules/domain-decisions.md) に従い、概念・単位・主体・根拠の意味を調査する。適用基準・許容例・似ているが拒否する反例を記す。未知の概念を既存の近いものへ無理に対応付けない。

| Kind / 区分 | Detail + impact / 内容・影響 | Evidence / 根拠 | Owner / 対応・判断者 |
|---|---|---|---|
| <Risk / Unknown / Assumption> | <specific / 具体的に> | <reference> | <AI investigation / Q-ID / existing acceptance> |

## Investigation dimensions / 検討観点

For every dimension in [ai-workflow](../rules/ai-workflow.md) §2, record a related Q-ID, AI technical decision, or reasoned N/A. Do not hide an uninvestigated dimension behind N/A.

[実行契約](../rules/ai-workflow.md) §2 の全観点について、関連 Q-ID / AI 技術判断 / 理由付き N/A を記す。見落としを N/A で隠さない。

## Questions

### Q1 — <Human decision / 人間が決めること>

**English**
- Background / concrete example:
- Why human authority is required:
- A: <effect on UX / data / compatibility / risk>
- B: <effect on the same dimensions>
- Recommendation + reason:
- What remains blocked without an answer:

**日本語**
- 背景・具体例:
- なぜ人間判断が必要か:
- A: <ユーザー体験・データ・互換性・リスクへの影響>
- B: <同じ軸での影響>
- 推奨と理由:
- 未回答で止まる範囲:

## Answers / Decision history — 回答・決定履歴

| Q-ID | Answer | Reason / 理由 | Source + date/reference / 回答元 | Status / 置換先 |
|---|---|---|---|---|
| Q1 | unanswered / 未回答 | — | — | Open |

Do not copy the recommendation into Answer. Do not silently overwrite a previous answer.  
推奨を Answer に代入しない。改訂前の回答を黙って上書きしない。

## AI technical decisions / AI の技術判断

| Item / 項目 | Decision / 判断 | Rule/code evidence / 根拠 | Why no human decision is required / 人間判断不要の理由 |
|---|---|---|---|
| <implementation detail> | <choice> | <rule/code> | <within delegated authority> |

## Decision → Acceptance Criteria / 決定 → 受け入れ条件

| Q-ID / decision | AC-ID | Preconditions/action/observable result / 前提・操作・結果 | SYS / FE-ID or method | docs |
|---|---|---|---|---|
| <Q-ID> | AC-01 | <positive/reverse/boundary> | <tracked during implementation> | <update target> |

## Unresolved / Deferred — 未決 / Defer

| Item / 項目 | blocker / defer | Reason + stopped scope / 理由・停止範囲 | Resume condition / follow-up Issue |
|---|---|---|---|

## Issue split / completion make — Issue 分割案 / 完了 make

AI specifies Pack / Flow / allowed paths / prohibitions / dependency order / completion commands. Ready means zero implementation blockers.

Pack / Flow / 許可パス / 禁止 / 依存順 / 完了コマンドを AI が具体化する。Ready の blocker は 0 件。実装後の進捗は Issue / PR に置く。
