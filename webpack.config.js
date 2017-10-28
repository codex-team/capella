const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');


const NODE_ENV = process.env.NODE_ENV || 'development';

module.exports = {
    entry: './public/app/entry.js',
    module: {
        rules: [
            {
                test: /.js$/,
                exclude: /node_modules/,
                use: ['babel-loader', 'eslint-loader']
            },
            {
                test: /.css$/,
                exclude: /node_modules/,
                loader: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: 'css-loader'
                })
            }
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public', 'build'),
        filename: 'bundle.js'
    },
    watchOptions: {
        aggregateTimeOut: 100
    },
    devtool: NODE_ENV === 'development' ? 'source-map' : false,
    plugins: [
        new ExtractTextPlugin('bundle.css')
    ]
};
