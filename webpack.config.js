'use strict';

// プラグインを利用するためにあらかじめwebpackを読み込んでおく
var webpack = require('webpack');
var precss = require('precss');
var autoprefixer = require('autoprefixer');
var path = require('path');

module.exports = {
    context: __dirname, // ビルド対象ディレクトリ
    watch: true, // watchモードを有効化
    entry: {
        bundle: './src/assets/js/bundle.js',
        "staff/bundle": './src/assets/js/staff/bundle.js'
    }, // エントリーポイントの設定
    output: {
        // filename: 'bundle.js', // 出力ファイル名
        filename: '[name].js', // 出力ファイル名([name]にはentryのkeyが入る)
        path: path.resolve(__dirname, 'public/js/'), // 出力パス
    },
    module: {
        exprContextCritical: false, // warning messageを非表示にする
        loaders: [ // ツールの読み込み
            /* JS */
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader?presets[]=es2015'] // ECMA2015
            },
            /* Font */
            // {test: /\.css$/, use: ['style-loader', 'css-loader']},
            {test: /\.svg$/, use: ['url-loader?mimetype=image/svg+xml']},
            {test: /\.woff$/, use: ['url-loader?mimetype=application/font-woff']},
            {test: /\.woff2$/, use: ['url-loader?mimetype=application/font-woff']},
            {test: /\.eot$/, use: ['url-loader?mimetype=application/font-woff']},
            {test: /\.ttf$/, use: ['url-loader?mimetype=application/font-woff']},
            /* CSS */
            {
                test: /\.css$/, use: ['style-loader', 'css-loader', { // postcss対応
                    loader: 'postcss-loader',
                    options: {
                        plugins: () => [
                            require('postcss-custom-properties')(),
                            require('postcss-nesting')()
                        ]
                    }
                }]
            },
            /* Image */
            {
                test: /\.(jpg|png)$/,
                loaders: 'url-loader'
            },
            {
                test: /\.vue$/,
                loader: 'vue'
            }
        ]
    },
    plugins: [ // プラグイン
        new webpack.optimize.UglifyJsPlugin({
            compress: { // 圧縮に関する設定
                warnings: false, // 警告を出力するかどうか
            }
        }),
        new webpack.ProvidePlugin({
            // $: 'jquery', // 全てのモジュールで変数 $ がjqueryを指す
            // jQuery: "jquery", // Bootstrap用
        })
    ],
    node: {
        fs: "empty"
    }
};
