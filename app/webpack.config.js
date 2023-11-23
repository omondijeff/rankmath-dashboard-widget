const path = require("path");

module.exports = {
  // Entry point of your application
  entry: "./src/index.js",

  // Output configuration for the compiled file
  output: {
    path: path.resolve(__dirname, "dist"), // Target directory
    filename: "app.bundle.js", // Output file
  },

  // Module rules and loaders
  module: {
    rules: [
      //Rules for Javascript/JSX
      {
        test: /\.(js|jsx)$/, // Target file extensions
        exclude: /node_modules/,
        use: {
          loader: "babel-loader", // Use Babel to transpile JS and JSX files
        },
      },

      // Rule for CSS Modules
      {
        test: /\.module\.css$/,
        use: [
          "style-loader",
          {
            loader: "css-loader",
            options: {
              modules: {
                localIdentName: "[name]__[local]___[hash:base64:5]",
              },
              sourceMap: true,
            },
          },
        ],
      },

      // Rule for regular CSS files (optional, if you have global CSS files)
      {
        test: /\.css$/,
        exclude: /\.module\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },

  // Resolve these extensions
  resolve: {
    extensions: [".js", ".jsx"],
  },
};
