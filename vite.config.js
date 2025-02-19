import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'
import path from 'node:path'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        //
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    vue({
      template: {
        preprocessOptions: {
          basedir: path.resolve(__dirname, './resources/js/'), // or something else here
        },
      },
    }),
  ],
  server: {
    hmr: {
      host: 'localhost',
    },
  },
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm.js',
      '@': '/resources/js/',
    },
  },
})
