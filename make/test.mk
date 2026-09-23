.PHONY: test test-back test-front

test: test-back test-front sit
	@echo "make test: すべて成功"

test-back:
	@$(MAKE) -C $(BACKEND_DIR) test

test-front:
	@$(MAKE) -C $(FRONTEND_DIR) test
