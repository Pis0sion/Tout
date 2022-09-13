APP_NAME = Tout-App
DOCKER_COMPOSE = docker-compose
GIT = /usr/bin/git
REPOSITORY = /data/Tout
TRAEFIK = $(REPOSITORY)/sTraefik
REDIS = $(REPOSITORY)/sRedis
ELASTICSEARCH = $(REPOSITORY)/sElastic

.BUILD_GOAL := all

.PHONY: install
install: gateway redis elasticsearch run

.PHONY: all
all: clean run

.PHONY: reload
reload: clean start

clean:
		@$(DOCKER_COMPOSE) down

gateway:
		@cd $(TRAEFIK) && $(DOCKER_COMPOSE) up -d

redis:
		@cd $(REDIS) && $(DOCKER_COMPOSE) up -d

elasticsearch:
		@cd $(ELASTICSEARCH) && $(DOCKER_COMPOSE) up -d

run:
		@cd $(REPOSITORY) && $(GIT) fetch && $(GIT) reset --hard origin/develop
		@$(DOCKER_COMPOSE) up -d

start:
		@$(DOCKER_COMPOSE) up -d


