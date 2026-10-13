# 6. Pack SoT / Contract Drift Audit — Pack の正本 / 契約ドリフト監査

## English

Audit Pack `<PACK_NAME>` for range `<AUDIT_RANGE>`.

Follow `AGENTS.md`, `docs/rules/ai-workflow.md` §6–§7, `docs/rules/domain-decisions.md`, and the evidence rules in `docs/rules/ai-review.md`. This audit detects and routes drift. It does not repair the Pack in this session.

A single PR review asks whether one change matches its contract. This audit asks whether the Pack, after accumulated change, still has one reconstructable meaning. It is not a gate on every change, and it does not replace Prompt 4.

The requester supplies the Pack and the range. Examples of a range are recent merges on the repository's integration branch, a completed Epic, or a series of changes that touch the same concept / ADR / Policy. Do not hard-code a branch name or a merge count.

### Rules

1. Reconstruct the Pack from the repository. Do not use memory of how it used to work.

2. Read only this Pack, in the AGENTS order: core-features, the Pack, its Flow IDs, the corresponding tests, and the implementation. Read concept, active ADR, Policy, and accepted Questions when meaning is in play. Then read the diffs in the audit range. Open generated survey or coverage only when needed. Coverage is not a higher source of truth.

3. Classify every mismatch as one of these kinds:
   - **Current-state:** use `implementation → system test → flow → generated coverage`. A stale doc is not a reason to delete implementation or tests.
   - **Target contract:** accepted Answers, Issue AC, active ADR, and Policy win over current implementation. Do not keep a contradicted implementation merely because implementation is first for current-state facts.

4. Start with paths the audit range touched. Follow dependencies and files absent from those diffs when the evidence says they carry the same contract.

5. Keep actor boundaries, aggregation units, evidence-promotion rules, and reasoned N/A. Do not drop a distinction because the Pack is complex. Do not require a document for a responsibility the flow marks N/A.

6. Set severity independently of routing.
   - **P1:** security, data loss, authorization, severe user-facing misbehavior, or an agreed-contract break that can cause those.
   - **P2:** a primary behavior's contract break, meaning drift, or an important regression.
   - **P3:** local doc drift, naming, or maintainability.

7. Give each finding one routing.
   - **Urgent fix:** the meaning is already determined and the impact should enter Prompts 3–5 now. Do not skip tests, doc alignment, or independent review.
   - **Issue:** the contract is clear and the repair can use the normal loop.
   - **Question:** meaning, scope, actor boundary, aggregation unit, evidence promotion, or risk acceptance is not determined. Return only these items to the human.
   - **ADR / Policy update:** a reusable decision should change. Do not edit that meaning inside the audit. Use Questions unless an active Policy already authorizes the update.
   - **No-action:** cite the contract, implementation, and tests that show the apparent mismatch is expected.

8. Do not implement the repair here, and do not start a broad rewrite. The next authorized prompt owns the fix.

9. Do not return a code review to the human. P1 does not create a human code-review gate.

10. Zero findings is valid only when the report names the Pack, the range, the sources actually read, and any check that could not be verified.

### Finding record

- Finding ID
- Conflict kind: current-state or target contract
- Severity and routing
- Pack / Flow ID
- Conflicting sources, with path, test, behavior, or commit
- Impact on users, data, security, or meaning
- Why this routing follows the existing contract
- For a Question only: why AI cannot decide, options, recommendation, and the answer that unblocks the repair

### Output

A. Reconstructed SoT, split into current-state facts and the agreed target contract

B. Findings

C. Severity, kept separate from routing

D. Recommended routing

E. Human Questions only

F. Areas checked with no drift, and the evidence

G. Confidence, unread areas, and verification gaps

## 日本語

Pack `<PACK_NAME>` を、範囲 `<AUDIT_RANGE>` について監査すること。

`AGENTS.md`、`docs/rules/ai-workflow.md` §6–§7、`docs/rules/domain-decisions.md`、および `docs/rules/ai-review.md` の証拠規則に従うこと。この監査はドリフトの検知と routing であり、このセッションでは Pack を修復しない。

個別 PR のレビューは、1 変更が契約に合っているかを見る。この監査は、変更が積み重なったあとも Pack が一つの再構成可能な意味を持つかを見る。毎変更の gate ではなく、Prompt 4 の代替でもない。

依頼者が Pack と範囲を指定する。範囲の例は、そのリポジトリの統合ブランチへの直近 merge、完了した Epic、同じ concept / ADR / Policy に触れた一連の変更である。ブランチ名や merge 回数を決め打ちしないこと。

### ルール

1. Pack をリポジトリから再構成すること。以前どう動いていたかの記憶を使わないこと。

2. この Pack だけを AGENTS の順で読むこと。core-features、Pack、Flow ID、対応する tests、implementation の順である。意味が関わるときだけ concept、active ADR、Policy、accepted Questions を読むこと。その後に監査範囲の diff を読むこと。生成済み survey / coverage は必要なときだけ開き、coverage を上位の正本にしないこと。

3. 不一致は次のどちらかに分類すること。
   - **現状事実:** `implementation → system test → flow → generated coverage` を使う。古い docs だけを理由に implementation や tests を削除しないこと。
   - **目標契約:** accepted Answers、Issue AC、active ADR、Policy は現在の implementation より優先する。現状事実の調査で implementation が上位であることを理由に、合意に反する implementation を残さないこと。

4. 監査範囲が触れた path から始めること。同じ契約を持つなら、依存先と、その diff に無いファイルも追うこと。

5. actor boundary、aggregation unit、evidence の昇格規則、理由付き N/A を維持すること。Pack が複雑であることだけを理由に区別を削らないこと。flow が N/A とした責務の文書を要求しないこと。

6. severity は routing と別に付けること。
   - **P1:** security、データ損失、認可、重大な利用者向け誤動作、またはそれらを起こしうる合意契約の破壊。
   - **P2:** 主要挙動の契約違反、意味のドリフト、重要な regression。
   - **P3:** 局所的な docs drift、命名、保守性。

7. finding ごとに routing を一つ付けること。
   - **Urgent fix:** 意味は既に決まっており、影響は今すぐ Prompt 3–5 へ入る。tests、docs の整合、独立レビューを省略しないこと。
   - **Issue:** 契約は明確で、修復は通常ループでよい。
   - **Question:** 意味、scope、actor boundary、aggregation unit、evidence の昇格、risk acceptance が決まっていない。人間へ戻すのはこの項目だけである。
   - **ADR / Policy update:** 再利用する決定自体を変える。監査の中でその意味を編集しないこと。active Policy が更新を既に許可している場合を除き、Questions を経由すること。
   - **No-action:** 見かけの不一致が想定どおりであることを、契約・implementation・tests を引用して示すこと。

8. ここで修復を実装せず、広範囲の書き換えも始めないこと。次に許可された prompt が修復を持つ。

9. 人間へコードレビューを返さないこと。P1 は人間のコードレビュー gate を作らない。

10. finding が 0 件でもよい。その場合も、Pack、範囲、実際に読んだ資料、検証できなかった項目を報告に含めること。

### Finding の記録

- Finding ID
- 不一致の種類: 現状事実、または目標契約
- Severity と routing
- Pack / Flow ID
- 衝突している資料。path、test、behavior、または commit を添える
- 利用者、データ、security、意味への影響
- この routing が既存契約に沿う理由
- Question の場合だけ: AI が決められない理由、選択肢、推奨、修復を再開する Answer

### 出力

A. 再構成した SoT。現状事実と合意済み目標契約を分ける

B. Findings

C. Severity。routing とは分ける

D. 推奨 routing

E. 人間への Questions だけ

F. ドリフトが無かった範囲とその証拠

G. 確度、未読の範囲、検証の欠落
