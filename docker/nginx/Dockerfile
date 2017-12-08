FROM debian:jessie

MAINTAINER CodeX Team <github.com/codex-team>

RUN apt-get update
RUN apt-get install -y nginx

ADD nginx.conf /etc/nginx/
ADD capella.conf /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/capella.conf /etc/nginx/sites-enabled/capella.conf
RUN rm /etc/nginx/sites-enabled/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
