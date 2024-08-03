<template>
    <div class="flex items-center justify-center h-screen text-white bg-gradient-to-r from-purple-700 to-pink-500">
    <div class="text-center">
      <h1 class="mb-4 text-6xl font-bold">Oops!</h1>
      <p class="mb-8 text-xl">The page you are looking for doesn't exist.</p>
      <router-link to="/" class="px-6 py-3 font-semibold text-purple-700 transition duration-300 ease-in-out bg-white rounded-full hover:bg-gray-300">Go back to Home</router-link>
    </div>
  </div>
</template>
<script>
export default {
    data(){
        return {
            logo_src: '/assets/img/logo' + process.env.MIX_CLIENT_CODE + '.svg',
            bg_src: '/assets/img/error.svg',
            error_title: '',
            error_message:'',
            error_explanation:'',
        }
    },
    props:{
        code: {
            type: String,
            default: '404'
        },
    }, 
    mounted() {
        document.title = this.$Lang_get('site_lang.error')+" | "+process.env.MIX_APP_NAME;
        if (this.code === '404') {
            this.error_title = this.$Lang_get('site_lang.page_not_found');
            this.error_message = this.$Lang_get('site_lang.page_not_found');
            this.error_explanation = this.$Lang_get('site_lang.page_not_found');
        }
        
    },
}
</script>

