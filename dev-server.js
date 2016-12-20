var webpack = require('webpack');
var WebpackDevServer = require('webpack-dev-server');
var config = require('./webpack.config.js');
var devServer = new WebpackDevServer(
    webpack(config, function(err, stats) {
        if(err) {
            console.log(err);
            throw err;
        }
        console.log(stats.compilation.errors);
    }),
    {
        //hot: true,
        contentBase: __dirname+'/web',
        publicPath: '/assets/'
    }
).listen(8088, 'localhost');
