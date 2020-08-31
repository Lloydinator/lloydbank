<template>
  <div class="container mx-auto my-20 py-5 border border-2 border-teal-500">
      <h1 class="font-mono text-xl text-center font-bold">LloydBank</h1>
      <div class="flex items-center py-10">
          <label class="flex-1" for="input">Enter your account ID:</label>
          <input 
            id="input" 
            class="appearance-none border border-2 border-teal-500 rounded flex-1 w-full text-gray-700 mr-3 py-1 px-2" 
            type="number" 
            v-model="accountID" 
            />
          <nuxt-link
            class="no-underline hover:no-underline bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
            :to="'/accounts/' + accountID"
          >
            Sign in
          </nuxt-link>
      </div>
  </div>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
  data() {
    return {
      accountID: 1
    };
  },
  components: {}
});
</script>
