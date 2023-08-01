# add2.app

It's a modular monolith implementation of application, that handles `Nutrition logs`. In next steps
it will be refactored to `microservices` architecture.

# Development

Use `makefile` in order to run common commands in convienient way:

```text
config_dump                    Displays merged docker-compose configuration
copy_vendor                    Copy vendor directory into a host machine
envs                           Debug env file
fast                           Attempts to start existing containers
params                         Debug container parameters
post_deploy                    Runs post deploy script that normally would be run in CI process
start                          Starts containers with build
stop                           Stops containers and removes network
tests_arch                     Runs architecture tests (deptrac)
tests_unit                     Runs unit tests
```

# Architecture

Application is written in Modular monolith manner and few constraints should be respected:

1. The only allowed dependency between modules is `any-module` to `shared-moduled`.
2. Modules should talk each other only via events - if direct call is needed, it should be considered as good refactor
   candidate (to move within the same scope).
3. Keep the dir structure flat as long as possible (with default Symfony recommendation).
4. Architecture can be validated by `deptrac`.
