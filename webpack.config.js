var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    entry: {
        build: [
            './app/Resources/js/main.js',
            './node_modules/bootstrap/dist/css/bootstrap.css',
            './app/Resources/css/main.css'
        ]
    },
    output: {
        filename: 'build.js',
        path: __dirname + '/web/assets'
    },
    module: {
        loaders: [
            { test: /\.css$/, loader: ExtractTextPlugin.extract('style-loader', 'css-loader') },
            { test: /bootstrap\/js\//, loader: 'imports?jQuery=jquery' },
            { test: /\.eot(\?v=\d+\.\d+\.\d+)?$/, loader: "file" },
            { test: /\.(woff|woff2)$/, loader:"url?prefix=font/&limit=5000" },
            { test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/, loader: "url?limit=10000&mimetype=application/octet-stream" },
            { test: /\.svg(\?v=\d+\.\d+\.\d+)?$/, loader: "url?limit=10000&mimetype=image/svg+xml" }

        ]
    },
    plugins: [
        new ExtractTextPlugin('build.css')
    ]
};