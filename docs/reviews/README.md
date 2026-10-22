# ローカルレビュー

横断リポジトリの照合スレッドを置く。手順の正本は [`docs/rules/ai-review.md`](../rules/ai-review.md) である。

`<Flow ID>/<YYYYMMDD>-<short-sha>-<short-sha>.md` の 1 ファイルが、照合したコード commit の組み合わせ 1 回である。ファイル名が索引である。照合では、その回のファイルだけを開く。`docs/reviews/` だけを変える commit は、新しい組み合わせにしない。
