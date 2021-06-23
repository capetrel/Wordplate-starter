user := $(shell id -u)
group := $(shell id -g)
php := 'php'
composer := 'composer'

.PHONY: help
	@grep -E '^[a-zA-Z_-]+:.*?## .$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?##"}; {printf "\033[36m%-30s\033[o0 %s\n", $$1, $$2}'

.PHONY: dev
dev: vendor $(assets) ## Lance le serveur de developpement
	$(php) -S 0.0.0.0:8000 -t web -d display_errors=1 -d max_execution_time=2

.PHONY: media
media: ## Régénère l'ensemble des médias pour wordpress
	./vendor/bin/wp media regenerate --yes