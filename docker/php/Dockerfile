ARG PHP_VERSION
FROM php:${PHP_VERSION}-cli

ARG HOST_USER

RUN apt-get update -qq \
    && apt-get install --no-install-recommends -qq \
        # for intl extension
        libicu-dev \
        # for pdo_pgsql extension
        libpq-dev \
        # for memcache installation and Composer
        unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
        bcmath \
        intl \
        mysqli \
        pdo_mysql \
        pdo_pgsql \
    > /dev/null

RUN yes '' | pecl -q install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -fsS https://getcomposer.org/installer -o composer-setup.php \
    && php -r "exit(strcmp(hash_file('SHA384', 'composer-setup.php'), '`curl -fs https://composer.github.io/installer.sig`'));" || echo 'Composer installer corrupt' \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/bin/composer

RUN sed -i "s/www-data:x:[0-9]\+:[0-9]\+/www-data:x:$HOST_USER/g" /etc/passwd

USER www-data
