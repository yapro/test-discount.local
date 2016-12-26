#!/usr/bin/env bash

# configure web-service:
echo -e '127.0.0.1\ttest-discount.local' >> /etc/hosts
ln -sf /var/www/test-discount.local/nginx.conf /etc/nginx/sites-enabled/test-discount.local.conf
service nginx reload
chmod -R 777 var/cache
chmod -R 777 var/logs
composer install

# install nodejs:
wget https://nodejs.org/download/release/v6.9.2/node-v6.9.2-linux-x64.tar.gz
tar -xzf "node-v6.9.2-linux-x64.tar.gz"
unlink node-v6.9.2-linux-x64.tar.gz
mv node-v6.9.2-linux-x64 nodejs
./nodejs/bin/npm i