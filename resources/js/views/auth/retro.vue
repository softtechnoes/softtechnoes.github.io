<template>
  <div class="container h-full px-4 mx-auto" >
    Welcome to retro
 </div>
</template>
<script>

import { mapActions,mapState } from 'vuex';
import { required, minLength, email, helpers } from '@vuelidate/validators';
import useVuelidate from "@vuelidate/core";

export default {
  components: {
  },
  data() {
    return {
      github: "/assets/img/github.svg",
      google : "/assets/img/google.svg",
      logo_src: '/assets/img/logo/kt-pink-tr.png',
      bg_src: '/assets/img/city.svg',
      email:'',
      password:'',
    };
  },
    mounted() {
        document.title = this.$Lang_get('auth.retro')+" | "+process.env.MIX_APP_NAME;
        
    },
    computed: {
    },
    methods: {
      ...mapActions('currentUser',['login','user_email_exists']),
      
      
    },
};
</script>
