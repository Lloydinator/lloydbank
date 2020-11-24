<template>
  <div class="bg-gray-200">
    <Navbar />
    <nuxt />
    <Footer />
  </div>
</template>
<script>
import Navbar from '~/components/Navbar'
import Footer from '~/components/Footer'

export default {
  components: {
    Navbar,
    Footer
  }
}
</script>

