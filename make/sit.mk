.PHONY: sit

sit:
	@cd $(BACKEND_DIR) && vendor/bin/phpunit -c phpunit.xml --testsuite System
