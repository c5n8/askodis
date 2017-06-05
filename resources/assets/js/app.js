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

    var popupSize = {
      width: 780,
      height: 550
    };

    $(document).on('click', '.share .item', function(e){
      var
        verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
        horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

      var popup = window.open($(this).prop('href'), 'social',
        'width='+popupSize.width+',height='+popupSize.height+
        ',left='+verticalPos+',top='+horisontalPos+
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

      if (popup) {
        popup.focus();
        e.preventDefault();
      }
    });
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
