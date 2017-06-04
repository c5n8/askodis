import 'bootstrap'
import vue from 'vue'
import store from 'store'
import http from 'lib/http'
import vueI18n from 'vue-i18n'
import { mapActions } from 'vuex'
import SearchBar from 'components/SearchBar'

vue.use(vueI18n)

const locale = document.documentElement.lang
const messages = {
  'en-US': {}
}

if (locale != 'en-US') {
  messages[locale] = {}
}

const i18n = new vueI18n({
  locale,
  messages
})

const app = new vue({
  store,
  i18n,
  components: {
    SearchBar
  },
  methods: {
    ...mapActions([
      'startClock',
      'stopClock'
    ]),
    auth() {
      if (document.head.querySelector('meta[name="user-id"]') == null) {
        $('#loginModal').modal('show')

        return false
      }

      return true
    }
  },
  mounted() {
    this.startClock()

    $('#settingsForm [name="locale"]').dropdown()
    $('#settingsForm [name="languages[]"]').dropdown()
    $('.ui.checkbox').checkbox()
  },
  destroyed() {
    this.stopClock()
  }
})

http
  .get('/lang/' + locale + '.json')
  .then(response => {
    i18n.setLocaleMessage(locale, response.data)

    app.$mount('#app')
  })
  .catch(error => {
    if (error.response.status === 404) {
      var fallbackLocale = 'en-US'

      http
        .get('/lang/' + fallbackLocale + '.json')
        .then(response => {
          i18n.locale = fallbackLocale
          i18n.setLocaleMessage(fallbackLocale, response.data)

          app.$mount('#app')
        })
        .catch(error => {
          app.$mount('#app')
        })

      return
    }

    app.$mount('#app')
  })
