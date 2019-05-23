// webpack.config.js

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require("path");

module.exports = (env, argv) => {
  const ENV = argv.mode === "production" ? "production" : "development";
  return {
    performance: {
      hints: false
    },
    entry: ["./src/js/app.js", "./src/sass/style.scss"],
    output: {
      filename: "theme.min.js",
      path: path.resolve(__dirname, "js")
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: "babel-loader"
          }
        },
        {
          test: /\.(png|jpg|jpeg|gif|svg)$/,
          use: "url-loader?limit=25000"
        },
        {
          test: /\.(scss)$/,
          use: [
            MiniCssExtractPlugin.loader,
            "css-loader",
            "sass-loader",
            {
              loader: "postcss-loader",
              options: {
                plugins: function() {
                  return [require("autoprefixer")];
                }
              }
            }
          ]
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: "../css/theme.min.css"
      })
    ],
    stats: {
      colors: true
    },
    devtool: ENV === "production" ? false : "source-map"
  };
};
