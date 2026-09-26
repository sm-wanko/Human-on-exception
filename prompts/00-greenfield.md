# 0. Greenfield bootstrap / Greenfield 初期化

Use this only when starting a new product from this repository's executable teaching example.

1. Run `make greenfield DRY_RUN=1`.
2. Confirm that only `EXAMPLE_*` teaching artifacts and their active shared references will be archived/reset.
3. If the plan is correct, run `make greenfield CONFIRM=1`.
4. Verify `make lint`, `make test`, and `make survey`.
5. Continue with [1B. Greenfield](./01-define-greenfield.md).

The archive lives under gitignored `.trash/examples/EXAMPLE_TASK_CRUD/`. It is temporary local evidence, not an active Source of Truth. AI, Make, tests, docs generation, and product discovery must not read `.trash/`.

## 日本語

この repo の実行教材から新規プロダクトを始める場合だけ使う。

1. `make greenfield DRY_RUN=1` を実行する。
2. `EXAMPLE_*` の教材成果物と、その active shared reference だけが退避・初期化対象であることを確認する。
3. 問題なければ `make greenfield CONFIRM=1` を実行する。
4. `make lint`、`make test`、`make survey` を確認する。
5. [1B. Greenfield](./01-define-greenfield.md) へ進む。

退避先 `.trash/examples/EXAMPLE_TASK_CRUD/` は gitignore 対象の一時ローカル保管庫であり、active Source of Truth ではない。AI の通常探索、Make、tests、docs generation、product discovery は `.trash/` を読まないこと。
