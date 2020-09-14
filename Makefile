.PHONY: all
all: coding-standards tests

.PHONY: coding-standards
coding-standards: vendor
	vendor/bin/phpcbf --standard=PSR2 -v src
	vendor/bin/phpstan analyse -l 7 src

.PHONY: tests
tests: vendor
	vendor/bin/phpunit tests

vendor: composer.json composer.lock
	composer validate
	composer install

.PHONY: server
server:
	php -S localhost:8000 -t public

