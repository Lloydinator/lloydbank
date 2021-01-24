<template>
<!-- component -->
<div class="bg-gray-200 min-h-screen pt-2 font-mono my-16">
    <div class="container mx-auto">
        <div class="inputs w-full max-w-2xl md:p-6 mx-auto">
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
                    <p>
                    <strong>Balance:</strong>
                    ${{ balance }}
                    </p>
                </div>
                </div>
            </section>
            <!-- component -->
            <div class="flex justify-center leading-loose mt-4">
                <div class="w-full max-w-xl md:m-4 px-2 py-6 md:p-10 bg-white rounded shadow-xl">
                    <p class="text-gray-800 font-medium border-b border-black mb-4">Customer information</p>
                    <Message :message="error" v-if="error" />
                    <Message :message="success" v-if="success" />
                    <div v-if="account">
                        <p class="mb-1">
                            <strong>Phone Number: </strong>
                            {{account.phone}}
                        </p>
                        <p class="mb-1">
                            <strong>Street: </strong>
                            {{account.street}}
                        </p>
                        <p class="mb-1">
                            <strong>City: </strong>
                            {{account.city}}
                        </p>
                        <p class="mb-1">
                            <strong>Zip: </strong>
                            {{account.zip}}
                        </p>
                    </div>
                    <form class="mb-8" v-else>
                        <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="cus_email">Phone Number</label>
                        <input 
                            class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" 
                            name="phone" 
                            type="tel" 
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            placeholder="Phone Number (Format: 123-456-7890)" 
                            v-model="userData.phone"
                        >
                        </div>
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
                    <div v-if="!cardnumber">
                        <div ref="cardelement"></div>
                        <button 
                            type="submit" 
                            id="card-button"
                            @click="setupIntent"
                            >Add Card
                        </button>
                    </div>
                    <p v-else>
                        <strong class="uppercase text-blue-800">{{cardbrand}}</strong>
                        *********{{cardnumber}}
                    </p>
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
            balance: 0,
            account: null,
            userData: {},
            error: null,
            success: null,
            clientSecret: '',
            card: null,
            cardnumber: null,
            cardbrand: null,
            stripe: {},
        };
    },
    components: {
        Message,
    },
    computed: {
        ...mapGetters(['loggedInUser'])
    },
    
    mounted(){       
        this.getAccountInfo()

        this.setElement()
    },
    methods: {
        setupIntent($event){
            $event.target.disabled = true

            this.stripe.confirmCardSetup(
                this.clientSecret,
                {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.$auth.$state.user.name,
                        },
                    },
                }
            )
            .then(
                res => {
                    if (res.error){
                        this.error = "Something went wrong"
                        this.$fire({
                            title: "Error!",
                            text: "Something went wrong",
                            type: 'error',
                            timer: 3000
                        })
                    }
                    else {
                        this.card.clear()
                        this.$fire({
                            title: "Success!",
                            text: "Card was successfully added.",
                            type: 'success',
                            timer: 3000
                        })
                        this.getAccountInfo()
                        this.setElement()
                    }
                }
            )
        },
        async getIntent(){
            this.$axios.get(`account/setup-intent/${this.$auth.$state.user.id}`,
                {
                    header: {
                        'Authorization': this.$auth.getToken('local')
                    }
                }
            )
            .then(
                res => {
                    this.clientSecret = res.data.intent
                }
            )
            .catch(e => {
                this.error = "Something went wrong"
            })
        },
        async onSubmit(event){
            event.preventDefault()
            event.target.disabled = true
            
            const data = new FormData()
            data.append('user_id', this.$auth.$state.user.id)
            data.append('phone', this.userData.phone)
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
                this.$fire({
                    title: "Success!",
                    text: response.data.message,
                    type: 'success',
                    timer: 3000
                })
                this.clearFields()
                this.getAccountInfo()
                this.setElement()
            }
            catch(e){
                $fivehundred = "Something was wrong with the info you put."
                $elser = "Something went horribly wrong."
                this.error = e.response.status == 500 ? fivehundred : elser
                this.$fire({
                    title: "Error!",
                    text: this.error,
                    type: "error",
                })
            }
        },
        getAccountInfo(){
            this.$axios.get('account/card',
                {
                    header: {
                        'Authorization': this.$auth.getToken('local')
                    }
                }
            )
            .then(res => 
            {
                this.cardnumber = res.data.card.last4
                this.cardbrand = res.data.card.brand
            })

            this.$axios.get('account/me',
                {
                    header: {
                        'Authorization': this.$auth.getToken('local')
                    }
                }
            )
            .then(
                res => {
                    this.account = res.data[0].account
                    this.balance = res.data[0].account.balance
                }
            )
        }, 
        setElement(){
            this.getIntent()

            this.stripe = Stripe(process.env.PUB_KEY)
            var elements = this.stripe.elements()
            this.card = elements.create('card')
            this.card.mount(this.$refs.cardelement)
        },
        clearFields(){
            this.userData.phone = ""
            this.userData.street = ""
            this.userData.city = ""
            this.userData.zip = ""
        }
    }
}
</script>