import 'pusher-js'
import echo from 'laravel-echo'

export default new echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: 'ap1',
  encrypted: true,
})
