import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue2'
import { fileURLToPath, URL } from 'node:url'
import path from 'node:path'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
    vue({
      // template: {
      //   preprocessOptions: {
      //     basedir: path.resolve(__dirname, './resources/js/'), // or something else here
      //   },
      // },
    }),
  ],

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      vue: 'vue/dist/vue.esm.js',
    },
  },
})
