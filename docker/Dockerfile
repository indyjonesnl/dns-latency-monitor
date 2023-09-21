FROM php:8.2-cli-alpine AS codebase

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    mongodb-stable

COPY --link ./bin/console /app/bin/console
COPY --link ./config/ /app/config/
COPY --link ./src/ /app/src/
COPY --link ./composer.* symfony.lock /app/


FROM codebase AS builder

ENV APP_ENV=prod

WORKDIR /app

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

RUN composer install \
    --no-dev \
    --no-progress \
    --optimize-autoloader


FROM codebase AS production

COPY --from=builder /app /app
RUN echo '<?php return [];' > /app/.env.local.php

WORKDIR /app
