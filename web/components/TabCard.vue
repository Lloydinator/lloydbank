<template>
    <div>
        <div class="flex justify-center mt-8">
            <ul class="flex">
                <li
                    class="cursor-pointer inline-block border-l border-t border-r rounded-t py-2 px-4 mr-1 text-blue-700 text-xl font-semibold"
                    v-for="tab in tabs"
                    :key="tab"
                    v-bind:class="{
                        'bg-white': activeTab === tab
                    }"
                    v-on:click="switchTab(tab)"
                >
                    <slot :name="tabHeadSlotName(tab)">
                        {{tab}}
                    </slot>
                </li>
            </ul>
        </div>
        <main class="bg-white shadow-lg rounded-lg p-4 mx-auto mt-1 mb-4 max-w-xl md:max-w-2xl ">
            <slot :name="tabPanelSlotName"></slot>
        </main>
    </div>
</template>
<script>
export default {
    name: 'TabCard',
    props: {
        initialTab: String,
        tabs: Array
    },
    data(){
        return {
            activeTab: this.initialTab
        }
    },
    computed: {
        tabPanelSlotName(){
            return `tab-panel-${this.activeTab}`
        }
    },
    methods: {
        tabHeadSlotName(tabName){
            return `tab-head-${tabName}`
        },
        switchTab(tabName){
            this.activeTab = tabName
        }
    }
}
</script>