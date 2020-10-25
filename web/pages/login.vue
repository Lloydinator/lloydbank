<template>
    <div class="bg-gray-200 min-h-screen flex flex-col">
        <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Log in</h1>
                <Message :message="error" v-if="error" />
                <form method="post" @submit="onSubmit">
                    <input 
                        type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="email"
                        v-model="entrance.email"
                        placeholder="Email" />
                    <input 
                        type="password"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="password"
                        v-model="entrance.password"
                        placeholder="Password" />
                    <div class="flex justify-center">
                        <button 
                            class="bg-green-600 hover:bg-green-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-grey-dark mt-6">
                Don't have an account?
                <nuxt-link class="no-underline text-blue-900 hover:text-blue-600" to="/register">
                    Register
                </nuxt-link>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue"
import Message from '~/components/Message'

export default Vue.extend({
  data() {
    return {
      entrance: {},
      error: null, 
      success: false
    };
  },
  components: {
    Message,
  },
  methods: {
    async onSubmit(evt){
      evt.preventDefault()
      try {
        let response = await this.$auth.loginWith(
          'local', 
          {data: this.entrance}
        )
        console.log(this.$auth.loggedIn)
        this.$router.push('/')
      }
      catch (e){
        this.error = e.response.data.message
      }
    }
  }
});
</script>