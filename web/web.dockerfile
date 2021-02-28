FROM nginx:1.18.0
ADD vhost.conf /etc/nginx/conf.d/default.conf