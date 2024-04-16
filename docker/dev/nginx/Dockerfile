FROM nginx:1.25-alpine

COPY ./docker/common/nginx/snippets /etc/nginx/snippets
COPY ./docker/dev/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1/health || exit 1
