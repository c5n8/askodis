const { mix } = require('laravel-mix')

mix
  .copy('resources/assets/lib/semantic/dist/semantic.css', 'resources/assets/sass/_semantic.scss')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .js('resources/assets/js/app.js', 'public/js')
  .extract([
    'axios',
    'jquery',
    'vue',
  ])
  .sourceMaps()
  .disableNotifications()
  // .browserSync(process.env.MIX_APP_URL)

if (mix.config.inProduction) {
  mix
    .version()
}
