<template>
<!-- component -->
<div class="bg-gray-200 min-h-screen pt-2 font-mono my-16">
    <div class="container mx-auto">
        <div class="inputs w-full max-w-2xl p-6 mx-auto">
            <h2 class="text-2xl border-b border-gray-400 text-gray-900">Account</h2>
            <section class="section">
                <div class="container">
                <div class="content">
                    <p>
                    <strong>Name:</strong>
                    {{ loggedInUser.name }}
                    </p>
                    <p>
                    <strong>Email:</strong>
                    {{ loggedInUser.email }}
                    </p>
                </div>
                </div>
            </section>
            <!-- component -->
            <div class="leading-loose">
                <div class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                    <Message :message="error" v-if="error" />
                    <Message :message="success" v-if="success" />
                    <form class="mb-8">
                        <p class="text-gray-800 font-medium border-b border-black mb-4">Customer information</p>
                        <div class="mt-2">
                        <label class=" block text-sm text-gray-600" for="cus_email">Address</label>
                        <input 
                            class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" 
                            name="street" 
                            type="text" 
                            placeholder="Street" 
                            v-model="userData.street"
                        >
                        </div>
                        <div class="mt-2">
                        <label class="hidden text-sm block text-gray-600" for="cus_email">City</label>
                        <input 
                            class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" 
                            name="city" 
                            type="text" 
                            placeholder="City" 
                            v-model="userData.city"
                        >
                        </div>
                        <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                        <label class="hidden block text-sm text-gray-600" for="cus_email">Zip</label>
                        <input 
                            class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" 
                            name="zip" 
                            type="text" 
                            placeholder="Zip" 
                            v-model="userData.zip"
                        >
                        </div>
                        <button type="submit" @click="onSubmit">Add Address</button>
                    </form>
                    <!-- card -->
                    <p class="mt-4 mb-4 text-gray-800 border-b border-black font-medium">Payment information</p>
                    <div ref="card"></div>
                    <button 
                        type="submit" 
                        id="card-button"
                        @click="paymentIntent"
                        >Add Card
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import {mapGetters} from 'vuex'
import Message from '~/components/Message'

export default {
    middleware: 'auth',
    name: 'account',
    data(){
        return {
            userData: {},
            error: null,
            success: null,
            intent: '',
            clientSecret: '',
            elements: null,
            card: null,
        };
    },
    components: {
        Message,
    },
    computed: {
        ...mapGetters(['loggedInUser'])
    },
    mounted(){
        this.elements = this.$stripe.import().elements()
        console.log(this.elements)
        this.card = this.elements.create('card', {})
        this.card.mount(this.$refs.card)

        this.getIntent()
    },   
    methods: {
        paymentIntent(evt){
            evt.preventDefault()
            
            self = this
            self.$stripe.import().confirmCardSetup(
                this.intent,
                {
                    payment_method: {
                        card: self.elements,
                        billing_details: {
                            name: self.$auth.$state.user.name,
                        },
                    },
                }
            )
            .then(
                res => {
                    if (res.error){
                        console.log(res.error)
                    }
                    else {
                        console.log(res)
                    }
                }
            )
        },
        async getIntent(){
            self = this
            self.$axios.get(`account/setup-intent/${self.$auth.$state.user.id}`,
                {
                    header: {
                        'Authorization': self.$auth.getToken('local')
                    }
                }
            )
            .then(
                res => {
                    self.intent = res.data.intent
                }
            )
            .catch(error => console.log(error))
        },
        async onSubmit(e){
            e.preventDefault()
            const data = new FormData()
            data.append('userid', this.$auth.$state.user.id)
            data.append('street', this.userData.street)
            data.append('city', this.userData.city)
            data.append('zip', this.userData.zip)

            try {
                let response = await this.$axios.post(
                    'account/create', data,
                    {
                        header: {
                            'Authorization': this.$auth.getToken('local')
                        }
                    }
                )
                this.message = response.data.message
            }
            catch(e){
                this.error = e.response.data.message
            }
        }
    }
}
</script>