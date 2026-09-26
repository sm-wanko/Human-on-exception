.PHONY: help test lint format typecheck

help:
	@echo "Frontend"
	@echo "  make test"
	@echo "  make lint"
	@echo "  make typecheck"

test:
	@if find src -type f \( -name '*.test.ts' -o -name '*.test.tsx' \) -print -quit | grep -q .; then pnpm test; else echo "Frontend tests: 0 product tests (greenfield)"; fi

lint:
	@pnpm lint:check

format:
	@pnpm format:fix

typecheck:
	@pnpm typecheck
