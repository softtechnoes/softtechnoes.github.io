<template>
    <router-view></router-view>
</template>

<script>
    export default {
        methods : {
        },
        data() {
            return {
                // transitionName: 'slide-right',
            };
        },
        watch: {
            // '$route' (to, from) {
            //     console.log(to);
            //     this.transitionName = 'slide-left';
            //     // 'fade'
            // }
        },
        destroyed(){
        }
    }
</script>
