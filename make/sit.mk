.PHONY: sit

# SIT is the backend System test suite and uses the same Docker-backed reporter as make test.
sit: test-env test-sit
	@echo "SIT report: $(COVERAGE_TESTS_DIR)/sit.md"
