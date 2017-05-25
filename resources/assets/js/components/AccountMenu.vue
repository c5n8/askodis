<template lang='jade'>
#accountMenu.ui.pointing.dropdown.link.item
  i.user.icon
  span.text Account
  .menu
    .item(@click="accountMenuClick") Logout
</template>

<script>
export default {
  methods: {
    accountMenuClick() {
      $('#logoutForm').submit();
    }
  },
  mounted() {
    $('#accountMenu').dropdown()
  }
}
</script>
