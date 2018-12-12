# Dockerfile
FROM php

MAINTAINER Bittu_Kumar <bittukumar1996@gmail.com>

WORKDIR /AgniKund

COPY AgniKund-XSS_Playground/. /AgniKund/

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "./", "./route.php"]
