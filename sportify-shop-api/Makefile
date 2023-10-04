#### DATABASE DEVELOPMENT ####

# Run `make db-drop` into your terminal to drop the database in the development's environment 
db-drop:
	php bin/console doctrine:database:drop --force
.PHONY: db-drop

# Run `make db-create` into your terminal to create a new database in the development's environment 
db-create:
	php bin/console doctrine:database:create
.PHONY: db-create

# Run `make db-migration` into your terminal to create a new migration
db-migration:
	symfony console make:migration
.PHONY: db-migration

# Run `make db-migrate` into your terminal to migrate the pending migration(s)
db-migrate:
	php bin/console doctrine:migrations:migrate
.PHONY: db-migrate

# Run `make db-fixtures` into your terminal to run your fixtures
db-fixtures:
	php bin/console doctrine:fixtures:load
.PHONY: db-fixtures

# Run `make db-validate` to check if your mapping and your databse are correctly set
db-validate:
	symfony console doctrine:schema:validate
.PHONY: db-validate

# Run `make debug-validator` to check if the Asserts from Entities are correctly set
debug-validator:
	php bin/console debug:validator src/Entity
.PHONY: debug-validator

# Run `make db-init` in your terminal to reset the database in the development's environment. This method regroups a large part of the database's methods above in one method. It can be modified if it's needed.
db-init:
	$(MAKE) db-drop
	$(MAKE) db-create
	$(MAKE) db-migration
	$(MAKE) db-migrate
	$(MAKE) db-fixtures 
.PHONY: db-init

#### DATABASE TESTS #####

# Run `make db-test-drop` into your terminal to drop the database in the test's environment 
db-test-drop:
	php bin/console d:d:d --force --if-exists --env=test
.PHONY: db-test-drop

# Run `make db-test-create` into your terminal to create the database in the test's environment 
db-test-create:
	php bin/console d:d:c --env=test
.PHONY: db-test-create

# Run `make db-test-migrate` into your terminal to migrate the database in the test's environment 
db-test-migrate:
	php bin/console d:m:m --no-interaction --env=test
.PHONY: db-test-migrate

# Run `make db-test-drop` into your terminal to run the fixtures in the test's environment
db-test-fixtures:
	php bin/console d:f:l --no-interaction --env=test
.PHONY: db-test-fixtures

# Run `make db-test-init` in the terminal to init the db for test
db-test-init:
	$(MAKE) db-test-drop
	$(MAKE) db-test-create
	$(MAKE) db-test-migrate
	$(MAKE) db-test-fixtures
.PHONY: db-test-init

# Run `make tests` in the terminal to run all tests"
tests:
	$(MAKE) db-test-init
	php bin/phpunit --testdox tests/Unit/
	php bin/phpunit --testdox tests/Functional/
.PHONY: tests

# Run unit tests
unit-test:
	$(MAKE) db-test-init
	php bin/phpunit --testdox tests/Unit/
.PHONY: unit-test

# Run functional tests
functional-test: 
	$(MAKE) db-test-init
	php bin/phpunit --testdox tests/Functional/
.PHONY: functional-test

