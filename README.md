Based on Symfony Standard Edition and some bunles
========================

How to configure

```
echo -e '127.0.0.1\ttest-discount.local' >> /etc/hosts
ln -sf /var/www/test-discount.local/nginx.conf /etc/nginx/sites-enabled/test-discount.local.conf
service nginx reload
chmod -R 777 var/cache
chmod -R 777 var/logs
```

How to install
```
composer install
```

JS
---

How to build project for product
```
npm test
```

How to start dev-server
```
npm start
```
and than open in browser: http://localhost:8088/webpack-dev-server/

How to restart node.js and dev-server
```
killall -9 node
node dev-server
```