<template>
    <div class="fixed top-0 left-0 z-50 flex items-center w-full h-full bg-background">
        <div class="flex flex-col justify-center w-full">
            <svg class="self-center w-10 h-10 fill-current animate-spin text-info" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M0 0h24v24H0z" fill="none"/><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
            </svg>
            <span class="w-full text-2xl font-semibold text-center text-info">{{message}}</span>
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