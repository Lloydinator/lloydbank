<template>
<!-- component -->
    <div>
        <div class="inputs w-full max-w-2xl p-6 mx-auto" v-if="card">
            <form class="mt-1 pt-4">
                <div class="max-w-xl md:m-4 px-2 py-6 bg-white rounded shadow-xl">
                    <h2 class="text-xl text-gray-900 mb-10 pb-2 border-b border-black">Send to:</h2>
                    <Message :message="error" v-if="error" />
                    <div class='w-full md:w-full md:px-3 mb-6'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xl font-mono mb-2' >Email Address</label>
                        <input 
                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' 
                            type='text' 
                            v-model="money.email"
                            required>
                    </div>
                    <div class='w-full md:w-full md:px-3 mb-6'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xl font-mono mb-2'>Amount</label>
                        <div class="flex">
                            <span class="text-4xl mr-2">$</span>
                            <input 
                                class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' 
                                type='text' 
                                v-model="money.amount"
                                required>
                        </div>
                    </div>
                    <div class='w-full md:w-full md:px-3 mb-6'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xl font-mono mb-2' >Message</label>
                        <textarea 
                            class='bg-gray-100 rounded-md border leading-normal resize-none w-full h-20 py-2 px-3 shadow-inner border-gray-400 font-medium placeholder-gray-700 focus:outline-none focus:bg-white' 
                            maxlenth='140' 
                            v-model="money.txnmessage"
                            required>
                        </textarea>
                    </div>
                    <div class="mb-6 pl-4">
                        <input 
                        type="radio" 
                        v-model="pick" 
                        :value="1"
                        >
                        <span class="text-md mr-8">
                            Public
                        </span>
                        <input 
                        type="radio" 
                        v-model="pick" 
                        :value="0"
                        >
                        <span class="text-md">
                            Private
                        </span>
                    </div>
                    <div class="flex justify-end">
                        <button 
                        class="appearance-none bg-teal-700 text-white px-2 py-1 shadow-sm border border-gray-400 rounded-md mr-3" 
                        type="submit"
                        @click="onSubmit"
                        >send money</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-center h-screen py-40" v-else>
            <h1 class="font-sans text-4xl font-bold text-gray-600">
                We're sorry, but you need to add a card first
            </h1>
        </div>
    </div>
</template>
<script>
import Message from "~/components/Message"

export default {
    middleware: 'auth',
    name: 'send-money',
    data(){
        return {
            money: {},
            pick: 1,
            error: null,
            success: null,
            card: false,
        };
    },
    components: {
        Message,
    },
    mounted(){
        this.getCard()
    },
    methods: {
        async onSubmit(evt){
            evt.preventDefault()
            const data = new FormData;
            data.append('from', this.$auth.$state.user.id)
            data.append('email', this.money.email)
            data.append('amount', this.money.amount)
            data.append('message', this.money.txnmessage)
            data.append('publictxn', this.pick)
            try {
                const response = await this.$axios.post('transaction/new', data)
                this.success = `You just sent ${response.data.sent}. 
                                Your balance is now ${response.data.balance}`
                this.$fire({
                    title: "Success!",
                    text: this.success,
                    type: 'success',
                    timer: 3000
                })
                this.clearFields()
            }
            catch(e){
                const fivehundred = `Something went horribly wrong. 
                                    You may have already been charged. Contact us.`
                const elser = "Something went wrong"
                this.error = e.response.status == 500 ? fivehundred : elser
                this.$fire({
                    title: "Error!",
                    text: this.error,
                    type: "error",
                })
            }
        }, 
        async getCard(){
            try {
                let response = await this.$axios.get('account/card',
                    {
                        header: {
                            'Authorization': this.$auth.getToken('local')
                        }
                    }
                )
                this.cardnumber = response.data.card.last4
                if (!this.cardnumber){
                    let cardMessage = `You need to add a card before 
                                        you can send money.`
                    this.$fire({
                        title: "Error!",
                        text: cardMessage,
                        type: "error",
                    })
                }
                else {
                    this.card = true
                }
            }
            catch(e){
                const errormessage = `You need to add a card before 
                                        you can send money. If you've 
                                        already added a card and you're 
                                        still seeing this, contact us.`
                this.$fire({
                    title: "Error!", 
                    text: errormessage,
                    type: "error",
                })
            }
        },
        clearFields(){
            this.money.email = ""
            this.money.amount = ""
            this.money.txnmessage = ""
            this.pick = 1
        }
    },
}
</script>