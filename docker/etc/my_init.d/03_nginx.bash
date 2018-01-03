#!/usr/bin/env bash
set -e
if [[ ! -f /etc/nginx/nginx.conf ]]; then
    echo "init nginx config"
	cp -ra /etc/nginx_default/* /etc/nginx
fi

service nginx start