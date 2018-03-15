const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const SplitByPathPlugin = require('webpack-split-by-path');
const HtmlWebpackPlugin = require('html-webpack-plugin');


const outputFolder = __dirname + '/public/theme/sanco/static';
const themeFolder = __dirname + '/public/theme/sanco/';
const nodeModules = path.join(__dirname, 'node_modules');
module.exports = {
    entry: {
        app: __dirname + '/public/theme/sanco/js/main.js',
    },
    output: {
        path: outputFolder,
        publicPath: '/theme/sanco/static/',
        filename: '[name].js',
        chunkFilename: "[name].js"
    },

    plugins: [
        new CleanWebpackPlugin([outputFolder], {root: __dirname, verbose: false, exclude: ['cache']}),
        new webpack.ProvidePlugin({'$': 'jquery', 'jQuery': 'jquery', 'window.jQuery': 'jquery', 'Bloodhound': 'typeahead.js/dist/bloodhound', 'moment': 'moment', '_': 'underscore'}),
        new SplitByPathPlugin([
            {
                name: 'vendor',
                path: path.join(__dirname, 'node_modules')
            }
        ], {
            manifest: 'app-entry'
        }),
        new HtmlWebpackPlugin({
            template: themeFolder + '/static-assets.ejs',
            filename: themeFolder + '/static-assets.twig',
            inject: false,
            hash: false
        }),
        new ExtractTextPlugin({
            filename: '[name].css'
        }),
        new CopyWebpackPlugin([
            { from: themeFolder + '/images', to: outputFolder + '/images' },
            { from: themeFolder + '/fonts', to: outputFolder + '/fonts' }
        ])
    ],
    resolve: {
        alias: {
            jquery: 'jquery/src/jquery',
        },
        extensions: ['.ts', '.tsx', '.js']
    },
    module: {
        rules : [
            {
                test: /\.ts(x?)$/,
                use: [
                    {
                        loader: 'ng-annotate-loader?add=true'
                    },
                    {
                        loader: 'ts-loader'
                    }
                ],
                exclude: /node_modules/
            },
            {
                test: /\.js(x?)$/,
                use: [
                    {
                        loader: 'ng-annotate-loader?add=true'
                    },
                    {
                        loader: 'babel-loader?presets[]=latest'
                    }
                ],
                exclude: /node_modules/
            },
            {
                test: /\.css/,

                loader: ExtractTextPlugin.extract({

                    loader: "css-loader!resolve-url-loader",
                }),
            },
            {
                test: /\.scss/,

                loader: ExtractTextPlugin.extract({
                    loader: "css-loader!resolve-url-loader!sass-loader?sourceMap",
                }),
            },
            {
                test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'url-loader?limit=10000&minetype=application/font-woff'
                    }
                ]
            },
            {
                test: /\.(ttf|eot|svg|otf)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'file-loader'
                    }
                ]
            },
            {
                test: /\.html$/,
                use: [
                    {
                        loader: 'html-loader?minimize=false&attrs=img:src img:error-src'
                    }
                ],
                exclude: /node_modules/
            },
            {
                test: /\.(png|jpg|gif)$/,
                use: [
                    {
                        loader: 'file-loader?name=img/[hash].[ext]'
                    }
                ]
            }
        ]
    },
    context: __dirname,
    devtool: 'source-map'
};