import 'bootstrap'
import vue from 'vue'
import store from 'store'
import { mapActions } from 'vuex'
import SearchBar from 'components/SearchBar'
import NotificationMenu from 'components/NotificationMenu'
import NotificationPopup from 'components/NotificationPopup'
import AccountMenu from 'components/AccountMenu'

const app = new vue({
  store,
  el: '#app',
  components: {
    SearchBar,
    NotificationMenu,
    NotificationPopup,
    AccountMenu
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
