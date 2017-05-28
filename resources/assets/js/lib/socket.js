import 'pusher-js'
import echo from 'laravel-echo'

export default new echo({
  broadcaster: 'pusher',
  key: '15a9d7c6cf426d9c4b86',
  cluster: 'ap1',
  encrypted: true
})
