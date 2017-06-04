import vue from 'vue'
import moment from 'moment'
import store from 'store'

vue.filter('humanizeDateTime', value => {
  return moment
    .utc(value)
    .utcOffset(moment().utcOffset())
    .from(store.state.clock.time)
  }
)

vue.filter('formatDateTime', value => {
  return moment
    .utc(value)
    .utcOffset(moment().utcOffset())
    .format('DD MMMM YYYY HH:mm')
  }
)
