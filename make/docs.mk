.PHONY: docs docs-consistency check-db-docs

docs:
	@cd $(ROOT_DIR) && python3 scripts/generate_endpoint_docs.py

docs-consistency: check-db-docs
	@cd $(ROOT_DIR) && python3 scripts/generate_endpoint_docs.py --check

check-db-docs:
	@cd $(ROOT_DIR) && python3 scripts/check_db_docs.py
