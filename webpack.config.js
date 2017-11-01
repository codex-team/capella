const ExtractTextPlugin = require('extract-text-webpack-plugin');
const webpack = require('webpack');

const NODE_ENV = process.env.NODE_ENV || 'development';


/**
 * Define entry point
 */
const entry = './public/app/entry.js';

/**
 * Set bundle params
 *
 * filename       - main bundle file from package.json
 * library        - module name from package.json
 * libraryTarget  - "umd" is a way for your library to work with all the module
 *                  definitions (and where aren't modules at all).
 *                  It will work with CommonJS, AMD and as global variable.
 */
const output = {
  filename: './public/build/bundle.js',
  library: 'capella',
};

const useModule = {
  rules: [
    {
      test: /.js$/,
      exclude: /node_modules/,
      use: [
        {
          loader: 'babel-loader',
          query: {
            presets: [ 'es2015' ],
          },
        },
        {
          loader: 'eslint-loader',
          options: {
            fix: true,
          },
        },
      ],
    },
    {
      test: /.css$/,
      exclude: [ /node_modules/ ],
      use: ExtractTextPlugin.extract([ {
        loader: 'css-loader',
        options: {
          minimize: 1,
          importLoaders: 1,
        },
      } ]),
    },
  ],
};

/**
 * List of plugins to run
 */
const plugins = [
  /** Build separated styles bundle */
  new ExtractTextPlugin({
    filename: './public/build/bundle.css',
    allChunks: true,
  }),

  /** Minify JS and CSS */
  new webpack.optimize.UglifyJsPlugin({
    sourceMap: true,
  }),

  /** Block biuld if errors found */
  new webpack.NoEmitOnErrorsPlugin(),
];

const watchOptions = {
  aggregateTimeOut: 100,
};

/**
 * Final webpack config
 */
const config = {
  entry,
  output,
  module: useModule,
  plugins,
  watch: true,
  watchOptions,
  devtool: NODE_ENV === 'development' ? 'source-map' : false,
};

module.exports = config;
