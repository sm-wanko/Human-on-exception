.PHONY: sit

sit:
	@if find $(BACKEND_DIR)/tests/System -name '*Test.php' -print -quit | grep -q .; then cd $(BACKEND_DIR) && vendor/bin/phpunit -c phpunit.xml --testsuite System; else echo "SIT: 0 product system tests (greenfield)"; fi
