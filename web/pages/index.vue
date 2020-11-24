<template>
  <div>
    <div
      class="flex flex-col min-w-0 break-words bg-white w-full md:w-6/12 mx-auto mt-20 mb-6 shadow-xl rounded-lg"
    >
        <div class="w-full px-4 mx-auto flex justify-center">
            <img
              alt="portrait"
              src="https://source.unsplash.com/800x800/?portrait"
              class="shadow-xl rounded-full h-auto align-middle border-none absolute -mt-16"
              style="max-width: 150px;"
            />
        </div>
        <div class="w-full lg:w-4/12 px-4 mt-20 mx-auto">
          <div class="flex justify-center py-4 lg:pt-4 pt-8">
            <div class="mr-4 p-3 text-center">
              <span
                class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                >${{balance}}</span
              ><span class="text-sm text-gray-500">Balance</span>
            </div>
            <div class="mr-4 p-3 text-center">
              <span
                class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                >0</span
              ><span class="text-sm text-gray-500">Friends</span>
            </div>
            <div class="lg:mr-4 p-3 text-center">
              <span
                class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                >{{mytransactions.length}}</span
              ><span class="text-sm text-gray-500">Transactions</span>
            </div>
          </div>
        </div>
        <div class="text-center mt-2 pb-12">
          <h3
            class="text-4xl font-semibold leading-normal mb-2 text-gray-800 mb-2"
          >
            {{name}}
          </h3>
          <div
            class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold lowercase"
          >
            <i
              class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"
            ></i>
            {{email}}
          </div>
        </div>
      </div>
    <TabCard :tabs="tabs" :initialTab="initialTab">
      <template slot="tab-head-global">
        Global
      </template>

      <template 
        slot="tab-panel-global"
      >
        <div id="global">
          <!-- post card -->
          <div 
            class="flex bg-white shadow-lg rounded-lg mx-auto my-4 max-w-xl md:max-w-2xl "
            :key="transaction.id"
            v-for="transaction in transactions"
          >
            <div class="flex items-start px-4 py-6">
                <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="https://images.unsplash.com/photo-1542156822-6924d1a71ace?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60" alt="avatar">
                <div class="">
                  <h2 class="text-2xl font-semibold text-gray-900 -mt-1 tracking-wide">{{transaction.txnparticipants.from_user.name}}</h2>
                  <p class="mt-1 text-gray-700 text-lg tracking-wide">
                      Sent <span class="text-md font-bold text-teal-800">${{transaction.amount}}</span> to 
                      <span class="text-xl text-blue-900">{{transaction.txnparticipants.to_user.name}}</span> 
                  </p>
                  <p 
                    class="mt-4 text-lg font-sans " 
                    v-if="transaction.message != null"
                  >
                    " {{transaction.message}} "
                  </p>
                  <div class="mt-4 flex items-center">
                      <div class="flex mr-8 text-gray-700 text-sm">
                        <svg fill="none" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                          </svg>
                        <span></span>
                      </div>
                      <div class="flex mr-8 text-gray-700 text-sm">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        <span></span>
                      </div>
                      <small class="text-sm text-gray-700">{{$moment(transaction.created_at).format("ddd, hA")}}</small>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </template>


      <template slot="tab-head-personal">
        Personal
      </template>

      <template slot="tab-panel-personal">
        <div id="personal">
          <!-- post card -->
          <div 
            class="flex bg-white shadow-lg rounded-lg mx-auto my-4 max-w-xl md:max-w-2xl "
            :key="mytransaction.id"
            v-for="mytransaction in mytransactions"
          >
            <div class="flex items-start px-4 py-6">
                <img class="w-12 h-12 rounded-full object-cover mr-10 shadow" src="https://images.unsplash.com/photo-1542156822-6924d1a71ace?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60" alt="avatar">
                <div class="">
                  <h2 class="text-2xl font-semibold text-gray-900 -mt-1">{{mytransaction.from_user.name}}</h2>
                  <p class="mt-1 text-gray-700 text-lg">
                      Sent <span class="text-md font-bold text-teal-800">${{mytransaction.transaction.amount}}</span> to 
                      <span class="text-xl text-blue-900">{{mytransaction.to_user.name}}</span>
                  </p>
                  <p 
                    class="mt-4 text-lg font-sans"
                    v-if="mytransaction.transaction.message != null"
                  >
                    " {{mytransaction.transaction.message}} "
                  </p>
                  <div class="mt-4 flex items-center">
                      <div class="flex mr-8 text-gray-700 text-sm">
                        <svg fill="none" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                          </svg>
                        <span></span>
                      </div>
                      <div class="flex mr-4 text-gray-700 text-sm">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        <span></span>
                      </div>
                      <small class="text-sm text-gray-700">{{$moment(mytransaction.created_at).format("ddd, hA")}}</small>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </template>
    </TabCard>
  </div>
</template>
<script>
import Vue from "vue"
import axios from "axios"
import TabCard from '~/components/TabCard'

export default {
  middleware: 'auth',
  components: {
    TabCard
  },
  data() {
    return {
      activeItem: 'global',
      payment: {},
      account: null,
      name: '',
      email: '',
      balance: 0,
      transactions: [],
      mytransactions: [],
      initialTab: 'global',
      tabs: ['global', 'personal']
    };
  },
  mounted() {
    this.$axios
      .get('account/me',
          {
              header: {
                  'Authorization': this.$auth.getToken('local')
              }
          }
      )
      .then(
          res => {
              this.name = res.data[0].name
              this.email = res.data[0].email
              this.balance = res.data[0].accounts.balance
          }
      )
    this.$axios
      .get('transactions/all', {
        headers: {
          'Authorization': this.$auth.getToken('local')
        }
      })
      .then(res => {
          let txn = res.data
          txn.forEach(data => this.transactions.push(data))
        }
      )
      .catch(e => {
        this.error = "Something went wrong"
      })

    this.$axios
      .get(`transactions/account/${this.$auth.$state.user.id}`, {
        headers: {
          'Authorization': this.$auth.getToken('local')
        }
      })
      .then(res => {
          let mytxn = res.data
          mytxn.forEach(data => this.mytransactions.push(data))
        }
      )
      .catch(e => {
        this.error = "Something went wrong"
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
