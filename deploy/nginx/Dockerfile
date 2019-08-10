FROM nginx:alpine

LABEL author="Artem Chernov"
LABEL maintainer="mail@vse-chetko.ru"

COPY deploy/nginx/conf/default.template /etc/nginx/conf.d/default.template

COPY public/ /www/public

CMD /bin/sh -c "envsubst '\$SERVER_NAME \$NGINX_PORT' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"
