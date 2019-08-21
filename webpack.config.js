const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const autoprefixer = require('autoprefixer');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');
const path = require('path');

module.exports = (env, options) => {
  console.log(options.mode);
  return {
    devtool: options.mode === 'development' ? 'eval-source-map' : false,
    devServer: {
      contentBase: path.join(__dirname, 'dist')
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader'
          }
        },
        {
          test: /\.(scss|css)$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader'
            },
            {
              loader: 'postcss-loader',
              options: {
                autoprefixer: {
                  browsers: ['last 2 versions']
                },
                plugins: () => [autoprefixer]
              }
            },
            {
              loader: 'sass-loader',
              options: {}
            }
          ]
        },
        {
          test: /\.(ico|gif|png|jpe?g|svg)$/,
          loaders: [
            {
              loader: 'file-loader'
            }
          ]
        }
      ]
    },
    optimization: {
      minimizer: [new OptimizeCSSAssetsPlugin({})]
    },
    plugins: [
      new WriteFilePlugin(),
      new MiniCssExtractPlugin({
        filename: '[name].css',
        chunkFilename: '[id].css'
      })
    ],
    watchOptions: {
      ignored: ['/node_modules/']
    }
  };
};
