# <Flow ID> ローカルレビュー

**テンプレートの使い方**: `docs/reviews/<Flow ID>/<YYYYMMDD>-<short-sha>-<short-sha>.md` として保存する。短縮 SHA は下の並び順にする。1ファイルは commit の組み合わせ 1 回である。

- 日付: YYYY-MM-DD
- backend: <リポジトリ名> <完全な commit>  PR #<番号>
- frontend: <リポジトリ名> <完全な commit>  PR #<番号>
- 照合: <指摘した側> / <返信した側>
- このファイルが証拠になるのは、上の commit の組み合わせだけである。

PR がまだ無い項目は `PR なし` と書き、PR を作ったときに番号を埋める。

## P1 <指摘の題>

- リポジトリ:
- パス: `path/file.php` L45
- commit:
- 発言者:
- 根拠:
- 影響:

```
引用した行
```

### 返信

- 発言者:
- 分類: valid / false positive / decision required
- 根拠:
