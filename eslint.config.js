import pluginJs from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import skipFormatting from '@vue/eslint-config-prettier/skip-formatting'

export default [
  {
    name: 'app/files-to-lint',
    files: ['**/*.{js,mjs,jsx,vue}'],
  },

  {
    name: 'app/files-to-ignore',
    ignores: [
      '**/dist/**',
      '**/dist-ssr/**',
      '**/coverage/**',
      'vendor/',
      'public/build/',
    ],
  },

  {
    name: 'app/jquery-global',
    languageOptions: {
      globals: {
        $: 'readonly',
      },
    },
  },

  pluginJs.configs.recommended,
  ...pluginVue.configs['flat/essential'],

  {
    name: 'app/overrides',
    rules: {
      'vue/multi-word-component-names': 'warn',
      'vue/no-deprecated-destroyed-lifecycle': 'warn',
      'vue/no-mutating-props': 'warn',
      'vue/return-in-computed-property': 'warn',
    },
  },

  skipFormatting,
]
