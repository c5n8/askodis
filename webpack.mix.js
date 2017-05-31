const { mix } = require('laravel-mix')
const BabiliPlugin = require('babili-webpack-plugin');

const webpackConfig = {
  resolve: {
    alias: {
      jquery: "jquery/src/jquery"
    },
    modules: [
      path.resolve('./resources/assets/js'),
      path.resolve('./node_modules')
    ],
    extensions: ['*', '.js', '.vue', '.json']
  }
}

mix
  .copy('resources/assets/lib/semantic/dist/semantic.css', 'resources/assets/sass/_semantic.scss')
  .copy('resources/assets/lib/semantic/dist/semantic.js', 'resources/assets/js/semantic-ui.js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .js('resources/assets/js/app.js', 'public/js')
  .extract([
    'axios',
    'diff',
    'jquery',
    'laravel-echo',
    'lodash',
    'moment',
    'pusher-js',
    'vue',
    'vuex',
  ])
  .disableNotifications()
  // .browserSync(process.env.MIX_APP_URL)

if (mix.config.inProduction) {
  webpackConfig.plugins = [new BabiliPlugin()]

  mix
    .options({
      uglify: false
    })
    .version()
} else {
  mix
    .sourceMaps()
}

mix.webpackConfig(webpackConfig)
