<template>
<div 
    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" 
    role="alert">
    <span class="block sm:inline font-bold">{{message}}</span>
</div>
</template>
<script>
export default {
    name: 'Message',
    props: ['message'],
}
</script>