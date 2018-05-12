const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    wcp: path.resolve(__dirname, '..', 'src/js/index.js'),
  },
  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, '..', '..', '..', 'web/wcp'),
    publicPath: '/wcp/',
  },
  resolve: {
    extensions: ['.js', '.jsx'],
    modules: [
      path.resolve(__dirname, '..', 'node_modules'),
      path.resolve(__dirname, '..', 'src'),
    ],
  },
  module: {
    rules: [
      { test: /\.(eot|woff|woff2|ttf|gif|svg)$/, loader: 'file-loader' },
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
        ],
      },
      {
        test: /\.jsx?$/,
        include: [
          path.resolve(__dirname, '..', 'src/js'),
        ],
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['env', 'stage-2', 'react-hmre', 'react', 'flow'],
          },
        },
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(['wcp'], { root: path.resolve(__dirname, '..', '..', '..', 'web') }),
    new HtmlWebpackPlugin({
      filename: 'index.html',
      template: 'src/assets/index.html',
      hash: true,
    }),
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: '[name].bundle.css',
      chunkFilename: '[id].[hash].css',
    }),
  ],
  optimization: {
    splitChunks: {
      minSize: 0,
      cacheGroups: {
        commons: {
          name: 'commons',
          chunks: 'initial',
          minChunks: 3,
        },
      },
    },
  },
};
