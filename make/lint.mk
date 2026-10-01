.PHONY: lint format lint-backend lint-frontend lint-export-comments

lint: lint-backend lint-frontend lint-export-comments

lint-backend:
	@$(MAKE) -C $(BACKEND_DIR) lint

lint-frontend:
	@$(MAKE) -C $(FRONTEND_DIR) lint
	@$(MAKE) -C $(FRONTEND_DIR) typecheck

lint-export-comments:
	@python3 scripts/check_export_comments.py

format:
	@$(MAKE) -C $(BACKEND_DIR) format
	@$(MAKE) -C $(FRONTEND_DIR) format
