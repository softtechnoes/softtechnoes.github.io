<template>
    <div>
      <CardProfile /> 
    </div>

</template>
<script>
import CardProfile from '../../components/Cards/CardProfile.vue';
import { mapActions, mapState } from 'vuex';

export default {
    name: "admin-layout",
    components: {
        CardProfile,
    },
    props: {
        token: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            logo_src: '/assets/img/logo' + process.env.MIX_CLIENT_CODE + '.svg',
            activation_message: '', 
        }
    },
    created(){
        document.title = this.$Lang_get('auth.profile')+" | "+process.env.MIX_APP_NAME;
    },
    computed:{
        ...mapState('currentUser',['auth_user']),
    }, 
    methods: {
        ...mapActions('currentUser',['activateUser']),
    }
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
