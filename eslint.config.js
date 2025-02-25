import pluginJs from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import skipFormatting from '@vue/eslint-config-prettier/skip-formatting'
import { ESLint } from 'eslint'

export default [
  {
    name: 'app/files-to-lint',
    files: ['**/*.{js,mjs,jsx,vue}'],
  },

  {
    name: 'app/files-to-ignore',
    ignores: ['**/dist/**', '**/dist-ssr/**', '**/coverage/**'],
  },

  {
    name: 'app/jquery-global',
    globals: {
      $: 'readonly',
    },
  },

  pluginJs.configs.recommended,
  ...pluginVue.configs['flat/essential'],
  skipFormatting,
]
