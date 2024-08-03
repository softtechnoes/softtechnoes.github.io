<template>
    <div class="flex flex-col w-full min-h-screen p-8 bg-background">
        <div class="flex justify-start w-full">
            <img :src="logo_src" class="self-center h-12 lg:h-14"/>
        </div>
        <div class="flex flex-col justify-center flex-grow w-full mb-24">
            <loader v-if="!activation_message" :message="$Lang_get('auth.loading_activation')"/>
            <span v-if="activation_message" class="w-full text-lg font-medium text-center text-danger">{{activation_message}}</span>
        </div>
    </div>
</template>
<script>
import loader from '../../components/reusables/loader.vue';
import { mapActions } from 'vuex';
export default {
    components: {
        loader
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
        document.title = this.$Lang_get('auth.account_deactivated')+" | "+process.env.MIX_APP_NAME;
    },
    mounted(){
        if(this.token){
            // Action to activate user
            this.activateUser(this.token).then(response => {
                if(response.status === 200){
                    // flash(response.data.message, 'success'); 
                    this.$swal({
                        text: response.data.message,
                        showConfirmButton: false,
                        position: 'top-end',
                        icon: "success", // error, info, warning, success
                        timer: 2000
                    });
                    localStorage.setItem('auth_token', response.data.token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
                    this.$router.push('/admin/dashboard')
                } else {
                    // flash(response.data.message, 'warning');
                    this.$swal({
                        text: response.data.message,
                        showConfirmButton: false,
                        position: 'top-end',
                        icon: "warning", // error, info, warning, success
                        timer: 2000
                    });
                }
            }).catch(error => {
                this.activation_message = error.response.data.errors.error[0];
                // flash(error.response.data.errors.error[0], 'error');
                this.$swal({
                    text: this.activation_message,
                    showConfirmButton: false,
                    position: 'top-end',
                    icon: "error", // error, info, warning, success
                    timer: 2000
                });
                setTimeout(() => {
                    this.$router.push("/auth/login");
                }, 3000)
            })
        }else{
            // TODO if there is no token, redirect to error page not found
            // this.activation_message =
        }
    }, 
    methods: {
        ...mapActions('currentUser',['activateUser']),
    }
}
</script>
