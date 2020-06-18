.PHONY: it
it: vendor

.PHONY: vendor
vendor:
	@docker-compose exec php composer install