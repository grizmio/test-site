FROM alpine:edge

WORKDIR /srv

ENV DATABASE_DSN="mysql:host=127.0.0.1;dbname=footest;charset=UTF8" \
    DATABASE_USER="" \
    DATABASE_PASSWORD="" \
    JWT_SECRET="s" \
    USER_SESSION_TIMEOUT=60

RUN apk --no-cache add php7 php7-pdo_mysql php7-mbstring php7-session php7-json php7-ctype

COPY ./ /srv/

# TODO: Redirigar la salida a /dev/null
CMD ["php7", "-S", "0.0.0.0:80", "bootstrap.php"]
