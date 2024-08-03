<template>
    <div class="flex justify-center"> 
        <span v-if="message">{{message}}</span>
        <div class="flex ml-4 space-x-2 animate-pulse">  
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
        </div>
    </div>  
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            
        };
    },
}
</script>