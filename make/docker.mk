.PHONY: up down build logs

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

logs:
	$(DOCKER_COMPOSE) logs -f

build:
ifeq ($(NO_CACHE),true)
	$(DOCKER_COMPOSE) build --no-cache backend frontend
else
	$(DOCKER_COMPOSE) build
endif
