const { merge } = require('webpack-merge');
const path = require('path');
const common = require('./webpack.common.js');
const { baseCss } = require('./webpack.ayudas');

module.exports = merge(common, {
  mode: 'development',
  devtool: 'inline-source-map',
  target: 'web',
  devServer: {
    static: path.join(__dirname, 'dist'),
  },
  module: {
    rules: [
      {
        test: /\.(css|scss)$/,
        use: [
          {
            loader: 'style-loader',
          },
          ...baseCss,
        ],
      },
    ],
  },
  watchOptions: {
    ignored: ['/node_modules/'],
  },
});
