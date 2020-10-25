<template>
  <div class="bg-gray-200 h-screen">
    <Navbar />
    <nuxt />
  </div>
</template>
<script>
import Navbar from '~/components/Navbar'

export default {
  components: {
    Navbar
  }
}
</script>

