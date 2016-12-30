Test task
========================
Backend based on Symfony Standard Edition 3.2 and some bundles (PHP 7.0)

Frontend based on Angular 1.6.0 and some dependencies (Node.js, npm, webpack)

Mysql is used to store data
```
CREATE DATABASE symfony;
```

How to install and configure

```
./install.sh
```

JS
---

How to build project for product
```
./nodejs/bin/node node_modules/webpack/bin/webpack.js -p --display-error-details
```
How to develop
```
./nodejs/bin/node node_modules/webpack/bin/webpack.js --watch
```

or alternative - start dev-server
```
./nodejs/bin/npm start
```
and than open in browser: http://localhost:8088/webpack-dev-server/ or http://localhost:8088/

How to restart node.js and dev-server
```
killall -9 node
./nodejs/bin/node dev-server
```