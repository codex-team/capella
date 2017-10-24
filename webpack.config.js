const path = require('path');


module.exports = {
    entry: './public/app/js/main.js',
    module: {
        rules: [
            {
                test: /.js$/,
                exclude: /node_modules/,
                use: 'babel-loader'
            }
        ]
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'bundle.js'
    }
};
