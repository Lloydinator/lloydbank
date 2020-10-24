<template>
  <nav class="navbar bg-teal-600 px-4 py-2">
    <div class="container">
      <div class="navbar-brand">
        <nuxt-link class="navbar-item font-mono text-3xl font-bold text-white" to="/">LloydBank</nuxt-link>
        <button class="button navbar-burger">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <div class="navbar-menu">
        <div class="navbar-end">
          <div class="navbar-item has-dropdown is-hoverable" v-if="isAuthenticated">
            <a class="navbar-link">
              {{ loggedInUser.username }}
            </a>
            <div class="navbar-dropdown">
              <nuxt-link class="navbar-item pr-5 text-lg text-white" to="/profile">My Profile</nuxt-link>
              <hr class="navbar-divider"/>
              <a class="navbar-item pr-5 text-lg text-white">Logout</a>
            </div>
          </div>
          <template v-else>
            <nuxt-link class="navbar-item pr-5 text-lg text-white" to="/register">Register</nuxt-link>
            <nuxt-link class="navbar-item pr-5 text-lg text-white" to="/login">Log In</nuxt-link>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['isAuthenticated', 'loggedInUser'])
    }
}
</script>