SHELL := /bin/bash

tests:
	symfony run bin/phpunit

.PHONY: tests