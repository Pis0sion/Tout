APP_NAME = Aseries-App
DOCKER_COMPOSE = docker-compose
GIT = /usr/bin/git
REPOSITORY = /data/Aseries
TRAEFIK = $(REPOSITORY)/sTraefik
REDIS = $(REPOSITORY)/sRedis
MEILISEARCH = $(REPOSITORY)/sMeilisearch

.BUILD_GOAL := all

.PHONY: install
install: gateway redis meilisearch run

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

meilisearch:
		@cd $(MEILISEARCH) && $(DOCKER_COMPOSE) up -d

run:
		@cd $(REPOSITORY) && $(GIT) fetch && $(GIT) reset --hard origin/develop
		@$(DOCKER_COMPOSE) up -d

start:
		@$(DOCKER_COMPOSE) up -d


