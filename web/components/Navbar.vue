<template>
  <nav class="relative flex flex-wrap items-center justify-between px-2 py-1 navbar-expand-lg bg-teal-600 mb-3">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
        <nuxt-link class="text-2xl font-mono leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap text-white" to="/">
          LloydBank
        </nuxt-link>
        <div v-if="isAuthenticated">
          <button 
            class="text-white cursor-pointer text-xl leading-relaxed px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" 
            type="button" 
            v-on:click="toggleNavbar()"
          >
            <font-awesome-icon :icon="['fas', 'bars']" />
          </button>
        </div>
      </div>
      <div v-if="isAuthenticated" >
        <div v-bind:class="{'hidden': !showMenu, 'flex': showMenu}" class="lg:flex lg:flex-grow items-center">
          <ul class="flex flex-col lg:flex-row list-none ml-auto">
            <li class="nav-item">
              <nuxt-link 
                class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" 
                to="/account"
              >
                {{loggedInUser.name}}
              </nuxt-link>
            </li>
            <li class="nav-item">
              <nuxt-link 
                class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" 
                to="/send"
              >
                Send money
              </nuxt-link>
            </li>
            <li class="nav-item">
              <a 
                class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug cursor-pointer text-white hover:opacity-75" 
                @click="logout"
              >
                Log out
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: "navbar",
    data(){
      return {
        showMenu: false
      }
    },
    computed: {
        ...mapGetters(['isAuthenticated', 'loggedInUser'])
    },
    methods: {
      toggleNavbar: function(){
        this.showMenu = !this.showMenu
      },

      async logout(){
        await this.$auth.logout()
      },
    }
}
</script>