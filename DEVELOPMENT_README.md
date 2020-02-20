# Development using a Docker Compose

You can set up a development environment for ZF1 unit testing and library 
development following these simple instructions.

### 1. Install requirements. (Note: these are not required by ZF1 itself)

- Docker (https://docs.docker.com/install/)
- Docker Compose (https://docs.docker.com/compose/install/)

### 2. Checkout repository to any location

    git clone git@github.com:vast-ru/zf1.git
    cd zf1

### 3. (Optional) Change host user id

If your current UID:GID is not 1000:1000, you can create `docker-compose.override.yml` file in project root
and specify your UID:GID there:

    version: "3"

    services:
      php71:
        build:
          args:
            HOST_USER: 33:33 # here
      php72:
        build:
          args:
            HOST_USER: 33:33 # and here

### 4. Build containers

    docker-compose build

> This will take a while as it has to download images and install required dependencies.
> Once it has finished, it will exit and leave you back at the command prompt.

### 5. Enter container interactive shell

    docker-compose run --rm php71 bash # for PHP 7.3
    docker-compose run --rm php72 bash # for PHP 7.4

> PHP 7.0 is not supported

### 6. Run tests

    ./bin/phpunit --stderr --configuration tests/phpunit.xml tests/Zend/Locale
    ./bin/phpunit --stderr --configuration tests/phpunit.xml tests/Zend/Measure/AngleTest.php
    (etc...)

> `--stderr` flag is needed to avoid `"Session must be started before any output has been
  sent to the browser"` error,
> because PHPUnit always outputs its version

## Using PhpStorm IDE for running tests

### 1. Add PHP interpreter

1. Go to `Settings` -> `Languages & Frameworks` -> `PHP`
2. Click `...` next to `CLI Interpreter`, then `+`,
   select `From Docker, Vagrant, VM, Remote...`
3. Select `Docker Compose`, then `php71` or `php72` as `Service`

### 2. Add test framework

1. Go to `Settings` -> `Languages & Frameworks` -> `PHP` -> `Test Frameworks`
2. Click `+`, select `PHPUnit by Remote Interpreter`, then select interpreter
3. Tick `Default configuration file`, enter `/www-data/zf1/tests/phpunit.xml`

### 3. Configure template

1. Go to `Run` -> `Edit Configurations`, select `Templates` -> `PHPUnit`
2. Enter `--stderr` into `Test Runner options` field

After these steps you can run and debug any test by selecting `Run` or `Debug` in
context menu 
