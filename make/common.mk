ROOT_DIR := $(abspath $(dir $(lastword $(MAKEFILE_LIST)))/..)
BACKEND_DIR := $(ROOT_DIR)/apps/backend
FRONTEND_DIR := $(ROOT_DIR)/apps/frontend
COVERAGE_DIR := $(ROOT_DIR)/coverage
COVERAGE_SURVEY_DIR := $(COVERAGE_DIR)/survey
