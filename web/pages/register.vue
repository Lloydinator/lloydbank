<template>
  <!-- component -->
    <div class="bg-gray-200 min-h-screen flex flex-col">
        <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Sign up</h1>
                <Message :message="error" v-if="error" />
                <form method="post" @submit="onSubmit">
                    <input 
                        type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="name"
                        v-model="entrance.name"
                        placeholder="Full Name" />
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
                            Register
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-grey-dark mt-6">
                Already have an account? 
                <nuxt-link class="no-underline border-b border-blue text-blue" to="/login">
                    Log in
                </nuxt-link>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue"
import Message from "~/components/Message"

export default Vue.extend({
  data() {
    return {
      entrance: {},
      error: null, 
    }
  },
  components: {
    Message,
  },
  methods: {
    async onSubmit(evt){
      evt.preventDefault()
      try {
        await this.$axios.post('register', this.entrance)
        await this.$auth.loginWith('local', {
          data: {
            email: this.entrance.email,
            password: this.entrance.password
          },
        })
        this.$router.push('/')
      }
      catch (e){
        const wrongLogin = "Something's not right"
        const wrong = "You may already have an account"
        this.error = e.response.status == 500 ? wrong : wrongLogin
      }
    }
  }
});
</script>