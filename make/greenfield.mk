.PHONY: greenfield greenfield-dry-run

greenfield:
	@python3 scripts/greenfield.py $(if $(filter 1 true yes,$(DRY_RUN)),--dry-run,) $(if $(filter 1 true yes,$(CONFIRM)),--confirm,)

greenfield-dry-run:
	@python3 scripts/greenfield.py --dry-run
