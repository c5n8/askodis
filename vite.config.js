import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/assets/css/app.css', 'resources/assets/js/app.js'],
      // input: ['resources/assets/sass/app.scss', 'resources/assets/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/assets/js', import.meta.url)),
      vue: 'vue/dist/vue.esm.js',
    },
  },
})
