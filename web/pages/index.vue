<template>
  <div>
    <div class="flex justify-center mt-8">
      <ul class="flex border-b">
        <li class="mr-1">
          <a 
            class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold"
            @click.prevent="setActive('global')"
            :class="{active: isActive('global')}"
            href="#global"
            >
            Global
          </a>
        </li>
        <li class="mr-1">
          <a 
            class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold"
            @click.prevent="setActive('personal')"
            :class="{active: isActive('personal')}"
            href="#personal"
            >
            Personal
          </a>
        </li>
      </ul>
    </div>
    <div class="flex justify-center">
      <div 
        class="inline-block border bg-white rounded mx-auto"
        :class="{'active show': isActive('personal')}"
        id="personal"
      >
        <div class="flex justify-center items-center align-center px-2 mt-4">
          <table class="shadow-lg bg-white w-full mb-4">
            <tr>
              <th class="bg-gray-500 border px-8 py-2">A/C To</th>
              <th class="bg-gray-500 border px-8 py-2">Amount</th>
              <th class="bg-gray-500 border px-8 py-2">Details</th>
              <th class="bg-gray-500 border px-16 py-2">Message</th>
            </tr>
            <tr :key="transaction.id" v-for="transaction in transactions">
              <td class="border px-8 py-2">{{transaction.to}}</td>
              <td class="border px-8 py-2">{{transaction.amount}}</td>
              <td class="border px-8 py-2">{{transaction.details}}</td>
              <td class="border px-16 py-2">{{transaction.message}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue"
import axios from "axios"

export default {
  middleware: 'auth',
  data() {
    return {
      //Before page load
      activeItem: 'global',
      payment: {},
      account: null,
      transactions: null,
    };
  },
  mounted() {
    axios
      .get('http://localhost:8000/api/transactions/all')
      .then(function(response) {
        this["transactions"] = response.data;
        
        var transactions = []
        for (let i = 0; i < that.transactions.length; i++) {
          transactions.push(that.transactions['$'+i]);
        }
        this.transactions = transactions;
        if (this.account) {
          this.loading = false;
        }
      })
  },
  methods: {
    isActive(menuItem){
      return this.activeItem === menuItem
    },
    setActive(menuItem){
      this.activeItem = menuItem
    }
  }
};
</script>
