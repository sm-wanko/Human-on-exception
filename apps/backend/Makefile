.PHONY: help test lint format

help:
	@echo "Backend (Laravel)"
	@echo "  make test"
	@echo "  make lint"
	@echo "  make format"

test:
	@vendor/bin/phpunit -c phpunit.xml

lint:
	@find app routes database tests -name '*.php' -print0 | xargs -0 -n1 php -l

format:
	@if [ -x vendor/bin/pint ]; then vendor/bin/pint; else echo "Pint not installed; skip"; fi
