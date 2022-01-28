tests:
	composer exec --verbose phpunit tests
test-coverage:
	export XDEBUG_MODE=coverage
	composer exec --verbose phpunit tests -- --coverage-text
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
install:
	composer install	

.PHONY: tests