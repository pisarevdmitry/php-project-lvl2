tests:
	composer exec --verbose phpunit tests
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests
install:
	composer install	

.PHONY: tests