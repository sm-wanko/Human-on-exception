# 00 existing tests / 既存テストの実行

Run the lint and test commands that [00-existing-adoption.md](./00-existing-adoption.md) already recorded for one unit. This prompt does not finish that adoption chart. The chart can be complete while this run has not started.

## English

Follow `AGENTS.md`. Use the commands recorded for that unit. PHPUnit and Vitest count even when the repository has no `make test`. A missing `make test` is not a failure when the recorded command is the one the repository actually has.

Run each recorded linter and test runner. Record the command and the result: pass, fail, or the reason it could not start. Do not invent a pass. Do not add tests, do not change product behavior, and do not audit missing cases or whether assertions match current behavior. Those belong to 00a and 00b inside the adoption prompt.

A failing result stays a result. It is not a product fix. Product changes start at `prompts/01-define-existing.md`.

Completion of this prompt is the recorded result. It is not SIT verification, and it is not completion of the adoption chart.

## 日本語

`AGENTS.md` に従うこと。その単位について記録済みのコマンドを使うこと。PHPUnit と Vitest は、`make test` が無くてもそのランナーである。リポジトリが実際に持つコマンドが記録されているとき、`make test` が無いことは失敗にしない。

記録された linter とテストランナーを、それぞれ起動すること。コマンドと結果を記録すること。結果は、緑、赤、または起動できなかった理由である。緑を捏造しないこと。テストは足さない。製品の挙動は変えない。ケースの漏れと、アサーションが現行の挙動と合っているかは見ない。それらは導入プロンプトの 00a と 00b に属する。

赤は結果のまま残す。製品の修正にはしない。製品の変更は `prompts/01-define-existing.md` から始める。

このプロンプトの完了は、記録された結果である。SIT 検証済みではなく、導入の資料の完了でもない。
