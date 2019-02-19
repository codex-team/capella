const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  /**
   * Define entry point
   */
  entry: {
    capella: './public/app/entry.js',
    hawk: './public/app/js/hawk.js'
  },

  /**
   * Set bundle params
   */
  output: {
    path: path.resolve(__dirname, 'public', 'build'),
    filename: '[name].bundle.js',
    library: '[name]'
  },

  /**
   * Loaders are used to transform certain types of modules
   */
  module: {
    rules: [
      /**
       * Process js files
       */
      {
        test: /\.js$/,
        exclude: [ /node_modules/ ],
        use: [
          {
            loader: 'babel-loader',
            query: {
              presets: [ '@babel/preset-env' ],
            },
          },
          {
            loader: 'eslint-loader',
            options: {
              fix: true,
            },
          },
        ]
      },

      /**
       * Process css files
       */
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'postcss-loader'
        ]
      }
    ]
  },

  /**
   * Adding plugins to configuration
   */
  plugins: [
    /** Used for migrating to newer webpack version */
    new webpack.LoaderOptionsPlugin({ options: {} }),

    /** Build separated styles bundle */
    new MiniCssExtractPlugin({
      filename: 'bundle.css',
    })
  ],

  /**
   * Rebuild bundles on files changes
   * Param --watch is a key for the command in the package.json scripts
   */
  watchOptions: {
    aggregateTimeout: 50,
  },

  /**
   * Optimization params
   */
  optimization: {
    noEmitOnErrors: true,
    splitChunks: false
  }
};