# リポジトリルート — 公開入口は help 参照
include make/common.mk
include make/test.mk
include make/lint.mk
include make/docs.mk
include make/survey.mk
include make/sit.mk

.PHONY: help

.DEFAULT_GOAL := help

help:
	@echo "プロジェクト共通コマンド（公開入口）"
	@echo ""
	@echo "  make test           Backend + Frontend + SIT"
	@echo "  make survey         構造調査 + docs 整合"
	@echo "  make docs           endpoint / transition docs 整合"
	@echo "  make lint"
	@echo "  make format"
	@echo ""
	@echo "SIT: make sit"
	@echo ""
	@echo "各サービス: apps/backend | apps/frontend の make help"
