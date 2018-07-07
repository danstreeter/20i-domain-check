FROM composer AS composer
WORKDIR /app
COPY ./composer.json .
RUN composer install --ignore-platform-reqs

FROM php:7.2-cli-alpine
LABEL 	maintainer="dan@danstreeter.co.uk" \
		description="An image to utilise the 20i API to perform a basic domain name availability check" \
		version="1.0.0"
WORKDIR /code
COPY --from=composer /app/vendor ./vendor
COPY ./code ./
ENTRYPOINT [ "php", "./domain-check.php" ]
