.PHONY: init-db clean-init init-user clean-db init-test-db test-init-db test-init reset-db init-sit-db clear-sit-db

init-db:
	@$(DOCKER_COMPOSE) exec backend php artisan migrate --force

clean-init:
	@$(DOCKER_COMPOSE) exec backend php artisan migrate:fresh --force

init-user:
	@echo "No default user seed is configured."

clean-db:
	@$(DOCKER_COMPOSE) exec backend php artisan migrate:fresh --force

init-test-db test-init-db test-init:
	@echo "Backend tests manage their own test DB."

reset-db: clean-db

init-sit-db clear-sit-db:
	@echo "System tests manage their own test DB lifecycle."
