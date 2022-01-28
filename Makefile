tests:
	composer exec --verbose phpunit tests
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-text
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
install:
	composer install	

.PHONY: tests