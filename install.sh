#!/usr/bin/env bash

# install nodejs:
wget https://nodejs.org/download/release/v6.9.2/node-v6.9.2-linux-x64.tar.gz
tar -xzf "node-v6.9.2-linux-x64.tar.gz"
unlink node-v6.9.2-linux-x64.tar.gz
mv node-v6.9.2-linux-x64 nodejs

# configure web-service:
sudo echo -e '127.0.0.1\ttest-discount.local' >> /etc/hosts
sudo ln -sf /var/www/test-discount.local/nginx.conf /etc/nginx/sites-enabled/test-discount.local.conf
sudo service nginx reload
chmod -R 777 var/cache
chmod -R 777 var/logs
composer install