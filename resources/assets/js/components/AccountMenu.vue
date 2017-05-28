<template lang='jade'>
#accountMenu.ui.pointing.dropdown.link.item
  i.user.icon
  span.text Account
  .menu
    .item(@click='onLogoutButtonClick') Logout
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
