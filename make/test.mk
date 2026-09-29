# Docker-backed test execution. Reports are written to coverage/tests/.
.PHONY: test test-env test-unit test-sit test-vitest test-vitest-integration test-summary test-back test-front

test: test-env
	@status=0; \
	$(MAKE) --no-print-directory test-unit || status=1; \
	$(MAKE) --no-print-directory test-sit || status=1; \
	$(MAKE) --no-print-directory test-vitest || status=1; \
	$(MAKE) --no-print-directory test-vitest-integration || status=1; \
	$(MAKE) --no-print-directory test-summary; \
	if [ $$status -eq 0 ]; then echo "make test: all test groups passed"; else echo "make test: one or more test groups failed"; fi; \
	exit $$status

test-env:
	@$(DOCKER_COMPOSE) up -d db backend frontend >/dev/null
	@mkdir -p $(BACKEND_DIR)/.test-results $(FRONTEND_DIR)/.test-results $(COVERAGE_TESTS_DIR)

test-unit:
	@rm -f $(BACKEND_DIR)/.test-results/unit.xml
	@status=0; $(DOCKER_COMPOSE) exec -T backend vendor/bin/phpunit -c phpunit.xml --testsuite Unit --log-junit .test-results/unit.xml || status=$$?; \
	if [ -f $(BACKEND_DIR)/.test-results/unit.xml ]; then \
		python3 scripts/generate_test_report.py --format phpunit --input $(BACKEND_DIR)/.test-results/unit.xml --output $(COVERAGE_TESTS_DIR)/backend-unit.md --title "Backend Unit Test Report"; \
	else \
		printf '# Backend Unit Test Report\n\nNo JUnit report was produced.\n' > $(COVERAGE_TESTS_DIR)/backend-unit.md; \
	fi; \
	exit $$status

test-sit:
	@rm -f $(BACKEND_DIR)/.test-results/system.xml
	@status=0; $(DOCKER_COMPOSE) exec -T backend vendor/bin/phpunit -c phpunit.xml --testsuite System --log-junit .test-results/system.xml || status=$$?; \
	if [ -f $(BACKEND_DIR)/.test-results/system.xml ]; then \
		python3 scripts/generate_test_report.py --format phpunit --input $(BACKEND_DIR)/.test-results/system.xml --output $(COVERAGE_TESTS_DIR)/sit.md --title "System Integration Test Report"; \
	else \
		printf '# System Integration Test Report\n\nNo JUnit report was produced.\n' > $(COVERAGE_TESTS_DIR)/sit.md; \
	fi; \
	exit $$status

test-vitest:
	@rm -f $(FRONTEND_DIR)/.test-results/vitest.json
	@status=0; $(DOCKER_COMPOSE) exec -T frontend pnpm exec vitest run --exclude='src/**/*.integration.test.tsx' --reporter=json --outputFile=.test-results/vitest.json || status=$$?; \
	if [ -f $(FRONTEND_DIR)/.test-results/vitest.json ]; then \
		python3 scripts/generate_test_report.py --format vitest --input $(FRONTEND_DIR)/.test-results/vitest.json --output $(COVERAGE_TESTS_DIR)/vitest.md --title "Frontend Vitest Report"; \
	else \
		printf '# Frontend Vitest Report\n\nNo JSON report was produced.\n' > $(COVERAGE_TESTS_DIR)/vitest.md; \
	fi; \
	exit $$status

test-vitest-integration:
	@rm -f $(FRONTEND_DIR)/.test-results/vitest-integration.json
	@status=0; $(DOCKER_COMPOSE) exec -T frontend pnpm exec vitest run integration.test.tsx --reporter=json --outputFile=.test-results/vitest-integration.json || status=$$?; \
	if [ -f $(FRONTEND_DIR)/.test-results/vitest-integration.json ]; then \
		python3 scripts/generate_test_report.py --format vitest --input $(FRONTEND_DIR)/.test-results/vitest-integration.json --output $(COVERAGE_TESTS_DIR)/vitest-integration.md --title "Frontend Vitest Integration Report"; \
	else \
		printf '# Frontend Vitest Integration Report\n\nNo JSON report was produced.\n' > $(COVERAGE_TESTS_DIR)/vitest-integration.md; \
	fi; \
	exit $$status

test-summary:
	@python3 scripts/generate_test_summary.py --dir $(COVERAGE_TESTS_DIR) --output $(COVERAGE_TESTS_DIR)/summary.md
	@echo "Test reports: $(COVERAGE_TESTS_DIR)/summary.md"

# Compatibility aliases.
test-back: test-unit test-sit
test-front: test-vitest test-vitest-integration
