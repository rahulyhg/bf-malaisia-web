// var ExtractTextPlugin = require('extract-text-webpack-plugin');
var webpack = require('webpack');
var isDebug = process.env.NODE_ENV === "dev";

function getPlugins() {
    var plugins = [
        //extract css from bundle.js file
        // new ExtractTextPlugin("../css/app.css"),

        //Make jQuery is global
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery",
            Popper: ['popper.js', 'default'],
            // In case you imported plugins individually, you must also require them here:
            Tether: "exports-loader?Tether!tether/dist/js/tether",
            Util: "exports-loader?Util!bootstrap/js/dist/util",
            Dropdown: "exports-loader?Dropdown!bootstrap/js/dist/dropdown"            
        })
    ];

    // Always expose NODE_ENV to webpack, you can now use `process.env.NODE_ENV`
    // inside your code for any environment checks; UglifyJS will automatically
    // drop any unreachable code.
    plugins.push(new webpack.DefinePlugin({
        'process.env': {
            'NODE_ENV': JSON.stringify(process.env.NODE_ENV)
        }
    }));

    // Conditionally add plugins for Production builds.
    !isDebug && plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            minimize: true,
            output: {
                comments: false
            },
            compressor: {
                warnings: false
            }
        })
    );

    return plugins;
}

module.exports = {
    entry: {
        ["index.min"]: ['babel-polyfill', __dirname + '/js/index.js']
    },
    output: {
        path: "",
        filename: __dirname + "/js/[name].js",
        libraryTarget: "var"
    },
    externals: {
        // require("jquery") is external and available
        //  on the global var jQuery
        "jquery": "jQuery"
    },
    module: {
        loaders: [
            // {
            //     test: /\.scss$/,
            //     loaders: ['style', 'css?url=false', 'sass'] //loader: ExtractTextPlugin.extract('css?-url&minimize!sass') /*do not split file:`loaders: ['style', 'css', 'sass']`*/
            // },
            {
                test: /\.js$/,
                loader: "imports-loader?this=>window"
            },
            {
                test: /\.js$/,
                // exclude: /(node_modules|bower_components)/,
                loader: 'babel',
                query: {
                    presets: ['es2015']
                }
            }
        ]
    },

    plugins: getPlugins(),

    resolve: {
        //user root or modulesDirectories to set the main directories
        // root: [
        //     path.resolve(__dirname),
        //     path.resolve("../img"),
        //     path.resolve(__dirname, "node_modules")
        // ],
        modulesDirectories: [
            __dirname, "node_modules", "js"
        ],
        extensions: ['', '.js', '.jsx']
    }
};