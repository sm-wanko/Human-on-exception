.PHONY: help test lint format

help:
	@echo "Backend (Laravel)"
	@echo "  make test"
	@echo "  make lint"
	@echo "  make format"

test:
	@if find tests -name '*Test.php' -print -quit | grep -q .; then vendor/bin/phpunit -c phpunit.xml; else echo "Backend tests: 0 product tests (greenfield)"; fi

lint:
	@find app routes database tests -name '*.php' -print0 | xargs -0 -n1 php -l

format:
	@if [ -x vendor/bin/pint ]; then vendor/bin/pint; else echo "Pint not installed; skip"; fi
