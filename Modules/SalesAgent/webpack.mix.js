const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../').mergeManifest();

mix.js(__dirname + '/Resources/js/app.js', 'public/js/salesagent.js')
    .sass( __dirname + '/Resources/sass/app.scss', 'public/css/salesagent.css');

if (mix.inProduction()) {
    mix.version();
}
