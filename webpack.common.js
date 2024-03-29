const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const path = require('path');

module.exports = {
  entry: {
    jcgj: './src/index.js',
    'jcgj-admin': './src/admin/admin.js',
    'jcgj-admin': './src/admin/admin.scss',
    'jcgj-upload': './src/admin/uploads.js',
    'jcgj-login': './src/admin/login.scss',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
      {
        test: /\.(ico|gif|png|jpe?g|svg)$/,
        type: 'asset/resource',
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(),
    new WriteFilePlugin(),
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    }),
  ],
  watchOptions: {
    ignored: ['/node_modules/'],
  },
};
