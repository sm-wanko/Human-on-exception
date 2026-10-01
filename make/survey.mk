# 構造保証（gap / route / matrix / docs 整合）。成果物は coverage/survey/
.PHONY: survey fe-survey

survey: _survey-scripts docs-consistency
	@echo "Survey 完了: $(COVERAGE_SURVEY_DIR)/ を確認"

_survey-scripts:
	@$(MAKE) _sit-route-flow-de-survey
	@$(MAKE) _sit-flow-scope-matrix-survey
	@$(MAKE) _sit-matrix-gap-survey
	@$(MAKE) _fe-survey

.PHONY: _sit-route-flow-de-survey _sit-flow-scope-matrix-survey _sit-matrix-gap-survey _fe-survey

_sit-route-flow-de-survey:
	@cd $(ROOT_DIR) && python3 scripts/sit_route_flow_de_survey.py --out $(COVERAGE_SURVEY_DIR)/route-survey

_sit-flow-scope-matrix-survey:
	@cd $(ROOT_DIR) && python3 scripts/flow_scope_matrix_api_survey.py --out $(COVERAGE_SURVEY_DIR)/matrix

_sit-matrix-gap-survey:
	@cd $(ROOT_DIR) && python3 scripts/sit_matrix_gap_survey.py --out $(COVERAGE_SURVEY_DIR)/sit-gap

_fe-survey:
	@cd $(ROOT_DIR) && python3 scripts/fe_flow_matrix_gap.py --out $(COVERAGE_SURVEY_DIR)/fe-gap

fe-survey: _fe-survey
