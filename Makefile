include make/common.mk
include make/docker.mk
include make/db.mk
include make/test.mk
include make/lint.mk
include make/docs.mk
include make/survey.mk
include make/sit.mk
include make/greenfield.mk

.PHONY: help
.DEFAULT_GOAL := help

help:
	@echo "プロジェクト共通コマンド（公開入口）"
	@echo ""
	@echo "  make build          NO_CACHE=true でキャッシュ無効"
	@echo "  make up / down / logs"
	@echo "  make test           Backend + Frontend + SIT"
	@echo "  make survey         構造調査 + docs 整合"
	@echo "  make docs           endpoint docs 整合"
	@echo "  make lint"
	@echo "  make format"
	@echo "  make greenfield      remove executable sample bundle and keep the AI-native skeleton"
	@echo ""
	@echo "DB: make init-db / clean-db / reset-db"
	@echo "SIT: make sit"
	@echo ""
	@echo "各サービス: apps/backend | apps/frontend の make help"
