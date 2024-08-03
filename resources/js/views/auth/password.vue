<template>
  <div class="container w-full min-h-screen px-1 mx-auto lg:px-8 md:container-md lg:container-lg">
    <div class="fixed bottom-0 right-0 z-0 flex content-center w-full h-screen bg-cover bg-background">
        <img :src="bg_src" class="self-center w-full opacity-30"/>
    </div>
    <div class="flex flex-col min-h-screen p-8">
      <div class="flex justify-start w-full">
          <img :src="logo_src" class="z-10 self-center h-12 lg:h-14"/>
      </div>
      <div class="z-10 flex flex-col items-center justify-center flex-grow w-full">
        <div class="flex flex-col items-center w-10/12 px-8 py-12 rounded-lg lg:py-16 lg:px-16 sm:w-10/12 md:w-8/12 lg:w-5/12 bg-tertiary">
          <span class="w-full text-lg font-bold text-center">{{$Lang_get('auth.reset_password')}}</span>
          <span class="w-full pt-6">{{$Lang_get('passwords.password')}}</span>
          <div class="flex flex-col w-full my-8 text-sm">
            <div class="flex justify-center"> 
                <svg class="h-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                <input type="password" v-model="$v.password.$model" @keyup.enter="handlesubmit" autocomplete="current-password" :class="status($v.password)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.new_password')" >
            </div>
            <div v-if="$v.password.$dirty" class="text-danger">
                <p class="ml-8" v-if="!$v.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
                <p class="ml-8" v-if="!$v.password.minLength">{{$Lang_get('passwords.password')}}</p>
            </div>
            <!-- Confirm password  -->
            <div class="flex justify-center mt-4">
                <svg class="h-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                <input type="password" v-model="$v.password_conf.$model" @keyup.enter="handlesubmit" autocomplete="current-password" :class="status($v.password_conf)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.confirm_password')" >
            </div>
            <div v-if="$v.password_conf.$dirty" class="text-danger">
                <div class="ml-8" v-if="!$v.password_conf.sameAsPassword">{{$Lang_get('validation.same', {'attribute' : $Lang_get('validation.attributes.password'), 'other' : $Lang_get('validation.attributes.password_confirmation')}) }}</div>
            </div>
          </div>
          <div class="flex items-center justify-center w-8/12 text-center lg:w-3/4 md:w-1/2">
            <loader v-if="isLoading" :message="$Lang_get('auth.loading')"/>
            <button v-else class="relative flex justify-center w-full px-2 py-1 text-lg font-bold border-2 rounded-lg lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white" @click="handlesubmit" >
              {{$Lang_get('auth.password_change_submit')}} 
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions,mapState } from 'vuex';
import { required, minLength,email,sameAs } from 'vuelidate/lib/validators'
import loader from '../../components/reusables/loader.vue';
export default {
    components: {
        loader
    },
    data() {
      return {
        logo_src: '/assets/img/logo' + process.env.MIX_CLIENT_CODE + '.svg',
        bg_src: '/assets/img/city.svg',
        email:'',
        resetToken: '',
        resetCode: '',
        password:'',
        password_conf:'',
        isLoading: false,
      }
    },
    validations: {
      password:{
          required,
          minLength: minLength(8)
        },
      password_conf: { required, sameAsPassword: sameAs('password') }
    },
    mounted() {
      document.title = this.$Lang_get('auth.reset_password')+" | "+process.env.MIX_APP_NAME;
      if(!this.$route.params.email){
        this.$router.push("/mot-de-passe-oublie");
      }else{
        this.email = this.$route.params.email;
        this.resetToken = this.$route.params.token;
        this.resetCode = this.$route.params.code;
        flash(this.$Lang_get('auth.reset_authorized'),'success');
      }      
    },
    computed: {
    },
    methods: {
      ...mapActions('currentUser',['login','user_email_exists','resetPasswordRequest','changePassword']),
    status(validation) {
        return {
          error: validation.$error,
          dirty: validation.$dirty
        }
      },
    handlesubmit(){
        this.$v.$touch();
        if (this.$v.$invalid) {
          return;
        }
        const payload = {
            email    : this.email,
            password : this.password,
            token    : this.resetToken, 
            code     : this.resetCode, 
        }
        this.isLoading = true;
        this.changePassword(payload).then(response=>{
            if(response.status===200){
              flash(response.data.message,'success')
              setTimeout(() => {
                  this.$router.push({path:'/connexion', query:{ email: this.email }});
              }, 3000)
            } else {
              this.resetForm();
              flash(this.$Lang_get('site_lang.server_error'),'error');
            }
            this.isLoading = false;
        }).catch(error=>{
            this.isLoading = false;
            flash(error.response.data.errors.error[0], 'error');
            setTimeout(() => {
                this.$router.push("/mot-de-passe-oublie");
            }, 3000)
        })
      },
    resetForm(){
          this.password = '',
          this.password_conf = ''
      }
    },
} 
</script>