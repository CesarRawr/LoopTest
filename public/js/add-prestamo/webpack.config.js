const webpack = require('webpack');
const path = require('path');

let config = {
  cache: false,
    entry: {
      main: [
      './_devapp/app.js',
      ]
    },
    output: {
    path: path.resolve(__dirname, 'assets', 'bundle'),
    filename: '[name].bundle.js'
  },
  resolve: {
        extensions: ['.js', '.jsx', '.json', '.ts', '.tsx']
    },
    module: {
    rules: [
      {
        test: /\.(js|jsx|tsx|ts)$/,
        exclude:path.resolve(__dirname, 'node_modules'),
        use: {
        loader: 'babel-loader',
        options: {
          presets: [
              '@babel/preset-env',
              '@babel/preset-react',
              '@babel/preset-typescript'
            ],
            plugins : [
              ["@babel/plugin-proposal-decorators", { "legacy": true }],
              '@babel/plugin-syntax-dynamic-import',
              ['@babel/plugin-proposal-class-properties', { "loose": true }]
            ]
          }
        },
      },
      {
        test: /.(png|woff(2)?|eot|ttf|svg|gif)(\?[a-z0-9=\.]+)?$/,
        use: [
        {
          loader: 'file-loader',
          options: {
            name: '../css/[hash].[ext]'
          }
        }
        ]
      },
      {
        test : /\.css$/,
        use: ['style-loader', 'css-loader', 'postcss-loader']
      }
    ]
  },
    plugins: [
    new webpack.DefinePlugin({
      '__DEV__' : JSON.stringify(true),
      '__API_HOST__' : JSON.stringify('http://localhost/my-app/'),
    }),
  ],
    
};

if (process.env.NODE_ENV === 'production') {
    config.plugins.push(
      new webpack.optimize.UglifyJsPlugin({
      sourceMap: false,
      compress: {
        sequences: true,
        conditionals: true,
        booleans: true,
        if_return: true,
        join_vars: true,
        drop_console: true
      },
      output: {
        comments: false
      },
      minimize: true
      })
    );
}

module.exports = config;