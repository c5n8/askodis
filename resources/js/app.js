import './bootstrap.js'
import vue from 'vue'
import store from './store/index.js'
import http from './lib/http.js'
import vueI18n from 'vue-i18n'
import { mapActions } from 'vuex'
import SearchBar from './components/SearchBar.vue'

vue.use(vueI18n)

let locale = document.documentElement.lang
const messages = {
  'en-US': {},
}

if (locale != 'en-US') {
  messages[locale] = {}
}

const i18n = new vueI18n({
  locale,
  messages,
  silentTranslationWarn: true,
})

const app = new vue({
  store,
  i18n,
  components: {
    SearchBar,
  },
  methods: {
    ...mapActions(['startClock', 'stopClock']),
    auth() {
      if (document.head.querySelector('meta[name="user-id"]') == null) {
        $('#loginModal').modal('show')

        return false
      }

      return true
    },
  },
  mounted() {
    this.startClock()

    $('#settingsForm [name="locale"]').dropdown()
    $('#settingsForm [name="languages[]"]').dropdown()
    $('.ui.checkbox').checkbox()

    const popupSize = {
      width: 780,
      height: 550,
    }

    $(document).on('click', '.share .item', function (e) {
      const verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
        horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2)

      const popup = window.open(
        $(this).prop('href'),
        'social',
        'width=' +
          popupSize.width +
          ',height=' +
          popupSize.height +
          ',left=' +
          verticalPos +
          ',top=' +
          horisontalPos +
          ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1',
      )

      if (popup) {
        popup.focus()
        e.preventDefault()
      }
    })
  },
  destroyed() {
    this.stopClock()
  },
})

http.get('/api/languages').then(async (response) => {
  const { data: languages } = response

  store.commit('concatLanguages', languages)

  const translation = await import(`../lang/${locale}.json`)
    .then((module) => module.default)
    .catch(async () => {
      locale = 'en-US'

      const module = await import(`../lang/${locale}.json`)

      return module.default
    })

  i18n.setLocaleMessage(locale, translation)
  i18n.locale = locale

  app.$mount('#app')
})
