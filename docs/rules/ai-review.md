# 独立 AI レビュー契約

## 実装者とレビュー者

レビュー者は Codex / Cursor Bugbot 等の別セッション・別コンテキストで起動する。実装者の自己レビューや単なる口調変更を独立レビューとして扱わない。実装者の「完了」宣言を信用の根拠にせず、Issue / 決定 / rules / diff / test を自分で確認する。

Codex の入口は root AGENTS.md の Review guidelines、Cursor Bugbot の入口は `.cursor/BUGBOT.md`。Copilot の設定を Codex 向け設定と取り違えない。サービス接続とレビュー自動実行設定は導入環境で確認し、未接続なら未実施と記録する。ファイル配置だけでレビュー済みにしない。

## レビュー観点

- 合意した AC・Scope・禁止への適合。現在実装の SoT と変更後の契約を区別する。
- 実バグ、回帰、認証・監査、データ破壊、Tx / 同時実行、作成・更新の対称性。
- UI 入口から成功・失敗・戻り先までの連続性。正常な空結果と取得不能を区別。
- 型・API・生成物・fake・テスト・4 点セットの追従。対になる機能も確認。
- 意味付けの唯一の正本、レイヤ責務、範囲外変更。
- [domain-decisions](./domain-decisions.md) に沿った concept・ADR・Policy の適用。集約単位や根拠の昇格条件、反例を壊していないか。複雑さへの指摘は守る要求と代替案を示す。
- 最新revisionの実行結果と完了主張の一致。集約のFail=0や除外されたIDで未検証を隠していないか。
- seed / migration と会員 UI mutation の監査差、理由付き N/A、確定済み制約を尊重する。

各指摘は severity、path / 行、根拠となる AC または rule、再現条件、影響範囲、修正方向を含める。推測だけの要求、スタイルのみ、称賛による水増しをしない。証明できない前提は明示する。

## 指摘対応ループ

1. 実装 AI が全指摘を一覧化し、valid / false positive / decision required に分類する。
2. valid は修正し回帰テスト・docs・検証を揃える。false positive は実装・テスト・合意契約の根拠を示す。単に「仕様です」で閉じない。
3. decision required は根拠と判断の選択肢を Questions へ。通常の修正は人間に聞かない。
4. 修正 commit・検証証拠と判断理由を PR に記録し、対応した thread を解決する。返信・resolve は利用環境の権限に従う。
5. 最新差分を別人格 AI が再確認する。指摘数 0、チェック成功だけを未実施レビューの代用にしない。過去 head のレビューは対象 revision を明記し、以降の差分を再評価する。

完了は [ai-workflow.md](./ai-workflow.md) §5。外部レビューの待機中は review pending であり、人間レビュー必須へすり替えない。
