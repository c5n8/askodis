<template lang='jade'>
#accountMenu.ui.pointing.dropdown.link.item
  i.user.icon
  span.text {{ $t('Account')}}
  .menu
    a.item(href='/my/settings') {{ $t('Settings')}}
    .item(@click='onLogoutButtonClick') {{ $t('Logout') }}
</template>

<script>
import http from 'lib/http'

export default {
  methods: {
    onLogoutButtonClick() {
      http.post('/logout').then(() => window.location.replace('/'))
    }
  },
  mounted() {
    $('#accountMenu').dropdown()
  }
}
</script>
