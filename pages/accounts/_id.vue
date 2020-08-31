<template>
  <div>
    <div class="container" v-if="loading">loading...</div>

    <div class="container" v-if="!loading">
      <b-card :header="'Welcome, ' + account.name" class="mt-3">
        <b-card-text>
          <div>
            Account: <code>{{account.id}}</code>
          </div>
          <div>
            Balance:
            <code
              >{{ account.currency === "1" ? "$" : "€"
              }}{{ account.balance }}</code
            >
          </div>
        </b-card-text>
        <b-button size="sm" variant="success" @click="show = !show"
          >New payment</b-button
        >

        <b-button
          class="float-right"
          variant="danger"
          size="sm"
          nuxt-link
          to="/"
          >Logout</b-button
        >
      </b-card>

      <b-card class="mt-3" header="New Payment" v-show="show">
        <b-form @submit="onSubmit">
          <input 
            type="hidden"
            :value="payment.from=account.id"
          >
          <input 
            type="hidden"
            :value="payment.currency_id=account.currency_id"
          >
          <b-form-group id="input-group-1" label="To:" label-for="input-1">
            <b-form-input
              id="input-1"
              size="sm"
              v-model.number="payment.to"
              type="number"
              required
              placeholder="Destination ID"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
            <b-input-group prepend="$" size="sm">
              <b-form-input
                id="input-2"
                v-model.number="payment.amount"
                type="number"
                required
                placeholder="Amount"
              ></b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group id="input-group-3" label="Message (optional):" label-for="input-3">
            <b-form-input
              id="input-3"
              size="sm"
              v-model="payment.message"
              placeholder="Your message (no more than 140 characters)"
            ></b-form-input>
          </b-form-group>

          <b-button 
            type="submit" 
            size="sm" 
            variant="primary"
            >Submit</b-button>
        </b-form>
      </b-card>

      <div class="flex justify-center mb-8">
        <div class="inline-block border bg-white rounded mx-auto mt-20">
          <div class="py-2 pb-4 w-full">
            <h1 class="font-sans text-center text-2xl">Payment History</h1>
          </div>
          <div class="flex justify-center items-center align-center px-2">
            <table class="shadow-lg bg-white w-full mb-4">
              <tr>
                <th class="bg-gray-500 border px-8 py-2">A/C To</th>
                <th class="bg-gray-500 border px-8 py-2">Amount</th>
                <th class="bg-gray-500 border px-8 py-2">Details</th>
                <th class="bg-gray-500 border px-8 py-2">Message</th>
              </tr>
              <tr :key="transaction.id" v-for="transaction in transactions">
                <td class="border px-8 py-2">{{transaction.to}}</td>
                <td class="border px-8 py-2">{{transaction.amount}}</td>
                <td class="border px-8 py-2">{{transaction.details}}</td>
                <td class="border px-8 py-2">{{transaction.message}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import Vue from "vue";

export default {
  data() {
    return {
      //Before page load
      show: false,
      payment: {},
      account: null,
      transactions: null,
      loading: true,
    };
  },
  mounted() {
    const that = this;

    axios
      .get(`https://fast-shore-29582.herokuapp.com/api/account/${this.$route.params.id}`)
      .then(function(response) {
        if (!response.data.length) {
          window.location.href = "/";
        } else {
          that.account = response.data[0];

          if (that.account) {
            that.loading = false;
          }
        }
      });

    axios
      .get(
        `https://fast-shore-29582.herokuapp.com/api/transactions/account/${
          this.$route.params.id
        }`
      )
      .then(function(response) {
        that["transactions"] = response.data;
        
        var transactions = [];
        for (let i = 0; i < that.transactions.length; i++) {
          that.transactions[i].amount =
            (that.transactions[i].currency_id === 1 ? "$" : "€") +
            that.transactions[i].amount;

          transactions.push(that.transactions[i]);
        }

        that.transactions = transactions;

        if (that.account) {
          that.loading = false;
        }
      });
  },

  methods: {
    onSubmit(evt: any) {
      var that = this;

      evt.preventDefault();

      //Update items on page after post
      const fetchInfo = () => {
        axios
          .get(`https://fast-shore-29582.herokuapp.com/api/account/${this.$route.params.id}`)
          .then(function(response) {
            if (!response.data.length) {
              window.location.href = "/";
            } else {
              that.account = response.data[0];
            }
          });

        axios
          .get(
            `https://fast-shore-29582.herokuapp.com/api/transactions/account/${
              that.$route.params.id
            }`
          )
          .then(function(response) {
            that["transactions"] = response.data;

            var transactions = [];
            for (let i = 0; i < that.transactions.length; i++) {
              that.transactions[i].amount =
                (that.transactions[i].currency === 1 ? "$" : "€") +
                that.transactions[i].amount;

              transactions.push(that.transactions[i]);
            }

            that.transactions = transactions;
          });
      };

      //Post data
      axios.post(
        `https://fast-shore-29582.herokuapp.com/api/transaction/new/`,
        this.payment,
      ).then(res => {
        alert(res.data.message);
        fetchInfo();
      }).catch(error => {
        alert("Something went wrong. Please try again.");
        console.log(error);
      }).finally(() => {
        that.payment = {};
        that.show = false;
      });
    }
  }
};
</script>
