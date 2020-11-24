<template>
  <div>
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
                  <div class="flex items-center space-x-12 justify-between">
                      <h2 class="text-lg font-semibold text-gray-900 -mt-1">{{transaction.txnparticipants.from_user.name}}</h2>
                      <small class="text-sm text-gray-700">{{$moment(transaction.created_at).format("ddd, hA")}}</small>
                  </div>
                  <p class="mt-1 text-gray-700 text-md">
                      Sent <span class="text-md font-bold text-teal-800">${{transaction.amount}}</span> to {{transaction.txnparticipants.to_user.name}} 
                  </p>
                  <p 
                    class="mt-4 text-lg font-sans " 
                    v-if="transaction.message != null"
                  >
                    " {{transaction.message}} "
                  </p>
                  <div class="mt-4 flex items-center">
                      <div class="flex mr-4 text-gray-700 text-sm">
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
                      <div class="flex mr-4 text-gray-700 text-sm">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                          </svg>
                        <span>share</span>
                      </div>
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
                <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="https://images.unsplash.com/photo-1542156822-6924d1a71ace?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60" alt="avatar">
                <div class="">
                  <div class="flex items-center space-x-12 justify-between">
                      <h2 class="text-lg font-semibold text-gray-900 -mt-1">{{mytransaction.from_user.name}}</h2>
                      <small class="text-sm text-gray-700">{{$moment(mytransaction.created_at).format("ddd, hA")}}</small>
                  </div>
                  <p class="mt-1 text-gray-700 text-md">
                      Sent <span class="text-md font-bold text-teal-800">${{mytransaction.transaction.amount}}</span> to {{mytransaction.to_user.name}} 
                  </p>
                  <p 
                    class="mt-4 text-lg font-sans"
                    v-if="mytransaction.transaction.message != null"
                  >
                    " {{mytransaction.transaction.message}} "
                  </p>
                  <div class="mt-4 flex items-center">
                      <div class="flex mr-2 text-gray-700 text-sm mr-3">
                        <svg fill="none" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                          </svg>
                        <span>12</span>
                      </div>
                      <div class="flex mr-2 text-gray-700 text-sm mr-8">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        <span>8</span>
                      </div>
                      <div class="flex mr-2 text-gray-700 text-sm mr-4">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                          </svg>
                        <span>share</span>
                      </div>
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
      transactions: [],
      mytransactions: [],
      initialTab: 'global',
      tabs: ['global', 'personal']
    };
  },
  mounted() {
    this.$axios
      .get('transactions/all', {
        headers: {
          'Authorization': this.$auth.getToken('local')
        }
      })
      .then(res => {
          let txn = res.data
          txn.forEach(data => this.transactions.push(data))
          console.log(this.transactions)
        }
      )
      .catch(e => console.log(e.message))

    this.$axios
      .get(`transactions/account/${this.$auth.$state.user.id}`, {
        headers: {
          'Authorization': this.$auth.getToken('local')
        }
      })
      .then(res => {
          let mytxn = res.data
          mytxn.forEach(data => this.mytransactions.push(data))
          console.log(this.mytransactions)
        }
      )
      .catch(e => console.log(e.message))
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
