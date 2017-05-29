import 'bootstrap'
import vue from 'vue'
import store from 'store'
import { mapActions } from 'vuex'
import SearchBar from 'components/SearchBar'

const app = new vue({
  store,
  el: '#app',
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
