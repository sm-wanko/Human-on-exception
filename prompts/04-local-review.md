# 4L. Local cross-repository review / 横断リポジトリのローカルレビュー

Optional. This is not an approval gate. Findings that the PR's own review service can see stay on `prompts/04-review.md`.

## English

Review one behavior whose code is not all visible from a single PR.

Follow `AGENTS.md` and `docs/rules/ai-review.md`. Use `docs/templates/local-review.md`. Work in a session that did not implement the change, and that can open every repository in the header.

Write one file:

`docs/reviews/<Flow ID>/<YYYYMMDD>-<short-sha>-<short-sha>.md`

The short SHAs follow the header order. One file is one combination of commits. A new commit gets a new file. Open that file only. Do not read the other files in the directory.

The header records each repository, its full commit, and its PR number. Leave the PR number blank until that PR exists, then fill it in. Do not put the PR number in the filename.

For each finding record the severity, repository, path, line, quoted lines, commit, author, supporting rule or AC, and impact. A reply records its author, `valid`, `false positive`, or `decision required`, and the contract or code it uses. A dismissal without that evidence does not close the finding.

Each repository's PR still gets `@codex review`. The PR body links to this file and the commit that contains it. Per-repository review success does not complete the cross-repository review. Return only `decision required` matters to Questions. Do not copy the thread into the 4-point set.

## 日本語

任意である。承認ゲートではない。PR 自身のレビューサービスが見られる指摘は `prompts/04-review.md` に残す。

1つの PR からコードの全体を見られない挙動を照合すること。

`AGENTS.md` と `docs/rules/ai-review.md` に従い、`docs/templates/local-review.md` を使うこと。実装したセッションとは別の、先頭に書く全リポジトリを開けるセッションで行うこと。

1回につき1ファイルを書くこと。

`docs/reviews/<Flow ID>/<YYYYMMDD>-<short-sha>-<short-sha>.md`

短縮 SHA は先頭に書いた順にする。1ファイルは commit の組み合わせ 1 回である。commit が増えたら新しいファイルにする。開くのはそのファイルだけとし、同じディレクトリの他のファイルは読まないこと。

先頭に、各リポジトリ、完全な commit、PR 番号を書くこと。PR が無いあいだ番号は空欄にし、PR を作ったときに埋めること。ファイル名に PR 番号を入れないこと。

各指摘に、重大度、リポジトリ、パス、行、引用、commit、発言者、根拠となる規則か AC、影響を書くこと。返信には、発言者、`valid` / `false positive` / `decision required`、使った契約かコードを書くこと。その根拠の無い却下は、指摘を閉じたことにしないこと。

各リポジトリの PR では `@codex review` も行うこと。PR 本文から、このファイルとその commit を指すこと。リポジトリごとのレビュー成功で、横断照合を完了にしないこと。`decision required` だけを Questions へ戻し、スレッドを 4 点セットへ写さないこと。
