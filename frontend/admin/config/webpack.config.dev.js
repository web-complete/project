const merge = require('webpack-merge');
const common = require('./webpack.config.common.js');
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
// const DashboardPlugin = require('webpack-dashboard/plugin');

module.exports = merge(common, {
  devtool: 'inline-source-map',
  devServer: {
    contentBase: '../../../web/wcp',
    hot: true
},
  plugins: [
    // new BundleAnalyzerPlugin()
    // new DashboardPlugin()
  ]
});