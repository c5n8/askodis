<template lang='jade'>
.share.ui.top.left.pointing.dropdown.tiny.basic.button
  i.share.icon
  strong {{ $t('Share')}}
  .menu
    a.item(
      :href='"https://www.facebook.com/sharer/sharer.php?u=" + shareable.shareUrl'
      target='_blank'
    )
      i.facebook.icon
      | Facebook
    a.item(
      :href='"https://twitter.com/intent/tweet?url=" + shareable.shareUrl'
      target='_blank'
    )
      i.twitter.icon
      | Twitter
    a.item(
      :href='"https://plus.google.com/share?url=" + shareable.shareUrl'
      target='_blank'
    )
      i.google.icon
      | Google+
</template>

<script>
export default {
  props: ['shareable'],
  mounted() {
    $('.share.button').dropdown()
  }
}
</script>
