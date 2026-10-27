# Questions の事実照合 — Questions

> 人間が答える前に、別コンテキストが事実と質問の根拠を見る契約。推奨は回答ではない。このファイルの Answer は、2026-10-27 の対話で述べられた順序を、原意のまま記録したものである。

**Status**: Ready（Q1 Accepted。実装 blocker 0 件）  
**Pack / Flow ID**: N/A。製品の Flow ではなく、01 の完了条件  
**Investigation revision**: `origin/main` @ `ad5f8f4`（2026-10-27）  
**Related**: [01-define](../../../prompts/01-define.md)、[01-define-existing](../../../prompts/01-define-existing.md)、[01-define-greenfield](../../../prompts/01-define-greenfield.md)、[ai-review](../../rules/ai-review.md)、Issue #29

## Goal / Scope

- **人間の意図**: Questions に書いた事実が誤ったまま答えると、02 以降がその回答を契約にする。答える前に、事実と質問の根拠を別コンテキストで見る。
- **Scope**: `01-define`、`01-define-existing`、`01-define-greenfield`。
- **Non-goals**: 00a / 00b の MUST 化。選択肢の採否。製品コードの変更。
- **Contracts to preserve**: 指摘 0 件で止まる。事実の誤りがすべて無いと証明できるまで続けない。推奨は回答にしない。実装側の自己レビューは独立レビューに数えない。

## Current facts

| ID | Fact | Evidence |
|---|---|---|
| F1 | 01 は、人間が答える前の別コンテキスト照合を、まだ要求していない | 変更前の三つのプロンプト |
| F2 | 00 のローカル完了は、別コンテキストの指摘 0 件で止まり、事実の不在証明までは続けない | `prompts/00-existing-adoption.md` |

## Questions

### Q1 — 人間が答える前に、何を照合して止めるか

- **背景**: 事実が誤った Questions に答えると、その回答が 02 の契約になる。03 以降は契約どおりかを見る。
- **なぜ人間の判断が要るか**: 答える前の必須工程を増やすかは、導入と新規の両方の完了条件である。
- **回答（対話 2026-10-27）**: 01 で Questions を作る。別コンテキストが、事実と質問の根拠を照合する。未解決の指摘が 0 件になってから、人間が Answer する。そのあとが 02 である。既存リポジトリでは、現行挙動の事実と、具体例・権限が要る理由・止まる範囲がコードまたは受け入れ済み決定とつながっているかを見る。グリーンフィールドでは、Current facts の区分、現行挙動の不作成、質問の根拠が意味・不可逆・リスク引き受け・規則の衝突であること、委譲済みの実装選択を質問にしていないことを見る。どちらも選択肢は選ばず、推奨を回答にしない。0 件のときも、質問が残っていないという主張を同じ照合にかける。follow-up Questions も、返す前に同じ照合を行う。

## Answers / Decision history

| Q-ID | Answer | Reason | Source + date | Status |
|---|---|---|---|---|
| Q1 | 上の順序と照合範囲 | 誤った前提のまま答えない。証明が終わるまで続けない | この対話、2026-10-27 | Accepted |

## AI technical decisions

| Item | Decision | Why no human decision is required |
|---|---|---|
| 止まり方の文言 | 00 で直した英語と同じく、反復して事実の不在を証明しない | 言語をまたいで完了条件を変えない |
| ファイル分割 | 入口のプロンプトに書き、共通の一文を `01-define.md` に置く | 既存のプロンプト配置に従う |

## Decision → Acceptance Criteria

| Q-ID | AC-ID | 観測可能な結果 | 検証 |
|---|---|---|---|
| Q1 | AC-01 | 既存の 01 は、答える前の照合対象を現行挙動の事実と質問の根拠とし、0 件で止めると読める | プロンプト文面 |
| Q1 | AC-02 | グリーンフィールドの 01 は、事実の区分、不作成、質問の根拠の四種、委譲済み実装を質問にしないこと、を照合対象とし、0 件で止めると読める | プロンプト文面 |
| Q1 | AC-03 | `01-define.md` は、どちらの入口でもその照合が済むまで Prompt 2 を始めないと読める | プロンプト文面 |

## Unresolved / Deferred

なし。再調査で新しい人間の権限は出ていない。

## Issue split / completion make

Epic なし。変更してよいパスは三つのプロンプトとこの Questions だけ。`make test` / `make survey` は、flow のマトリクスも 4 点セットも変えないため、この契約の証拠ではない。確認は AC-01〜03 と文面の照合。
