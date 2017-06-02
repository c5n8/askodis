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
  "${locale}": {}
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
  },
  mounted() {
    this.startClock()
  },
  destroyed() {
    this.stopClock()
  }
})

http
  .get('lang/' + locale + '.json')
  .then(response => {
    i18n.setLocaleMessage(locale, response.data)

    app.$mount('#app')
  })
  .catch(error => {
    app.$mount('#app')
  })
