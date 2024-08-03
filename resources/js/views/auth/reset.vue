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
        <div class="flex flex-col items-center w-10/12 px-8 py-12 rounded-lg lg:py-16 lg:px-16 sm:w-10/12 md:w-8/12 lg:w-5/12 bg-tertiary" v-if="resetStep === '1_reset_request'">
          <span class="w-full text-lg font-bold text-center">{{$Lang_get('auth.reset_password')}}</span>
          <span class="w-full pt-6">{{$Lang_get('auth.enter_email_to_reset')}}</span>
          <div class="flex flex-col w-full my-8 text-sm">
            <div class="flex justify-center">
              <svg class="h-4 my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              <input @keyup.enter="sendResetPasswordRequest()" @input="checkIfExists()" v-model="$v.email.$model" type="email" autocomplete="email" :class="status($v.email)" class="w-full h-8 py-1 ml-2 border form-input lg:py-2" :placeholder="$Lang_get('auth.email')">
            </div>
            <div v-if="$v.email.$dirty" class="text-danger">
              <p class="ml-8" v-if="!$v.email.email">{{$Lang_get('validation.email', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
              <p class="ml-8" v-if="!$v.email.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
            </div>
          </div>
          <div class="flex items-center justify-center w-8/12 text-center lg:w-3/4 md:w-1/2">
            <loader v-if="isLoading" :message="$Lang_get('auth.loading')"/>
            <button class="relative flex justify-center w-full px-2 py-1 text-lg font-bold border-2 rounded-lg lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white" @click="sendResetPasswordRequest()" v-if="!isLoading">
             {{$Lang_get('auth.send_pwc_reset_email')}} 
            </button>
          </div>
        </div>
        <div class="flex flex-col items-center w-10/12 px-8 py-12 rounded-lg lg:py-16 lg:px-16 sm:w-10/12 md:w-8/12 lg:w-5/12 bg-tertiary" v-if="resetStep === '2_reset_authorization'">
          <span class="w-full text-lg font-bold text-center">{{$Lang_get('auth.reset_password')}}</span>
          <span class="w-full pt-6">{{$Lang_get('auth.reset_password_expl')}}</span>
          <div class="flex flex-col w-full my-8 text-sm">
            <div class="flex justify-center">
              <svg class="h-4 my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
              <input @keydown.space.prevent @keyup.enter="verifyResetCode()" v-model="resetCode" type="text" class="w-full h-8 py-1 ml-2 bg-transparent border rounded-lg placeholder-secondary lg:py-2 form-input" :placeholder="$Lang_get('auth.reset_code')" >
            </div>
          </div>
          <div class="flex items-center justify-center w-8/12 mb-8 text-center lg:w-3/4 md:w-1/2">
            <loader v-if="isLoading" :message="$Lang_get('auth.loading')"/>
            <button v-else class="relative flex justify-center w-full px-2 py-1 text-lg font-bold border-2 rounded-lg lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white" @click="verifyResetCode()" >
              {{$Lang_get('auth.validate_code')}}
            </button>
          </div>
          <span class="py-4 border-t-2 text-secondary border-secondary">{{$Lang_get('auth.reset_resend_expl')}}</span>
          <loader v-if="resendIsLoading" :message="$Lang_get('auth.loading')"/>
          <div v-if="!resendIsLoading" class="flex flex-col items-center w-full">
            <button @click="resendResetPasswordRequest()" v-if="countDownBeforeResend === 0" class="relative flex justify-center w-8/12 px-2 py-1 text-lg border-2 rounded-lg text-secondary lg:w-3/4 md:w-1/2 lg:px-4 lg:py-2 border-secondary hover:bg-secondary hover:text-white">
              {{$Lang_get('auth.resend_reset')}} 
            </button>  
            <span v-if="countDownBeforeResend === 0" class="pt-2 text-secondary">{{email}}</span>
            <div v-if="countDownBeforeResend > 0" class="flex flex-col items-center text-secondary">
              <span class="">{{$Lang_get('auth.resend_wait')}}</span>
              <span class="text-2xl">{{countDownBeforeResend}}</span>    
            </div>
          </div>
        </div>
      </div>
      <footer class="flex items-center justify-between pb-10 text-sm md:text-md lg:text-lg">
        <button class="z-10 flex flex-col items-center justify-center text-center focus:outline-none group">
          <router-link to="/connexion" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.login') }}</span></router-link>
          <div class="w-full mt-1 border-t-8 rounded-md group-hover:w-8/12 border-tertiary"></div>
        </button>
        <button class="z-10 flex flex-col items-center justify-center text-center focus:outline-none group">
          <router-link to="/inscription" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.register') }}</span></router-link>
          <div class="w-full mt-1 border-t-8 rounded-md group-hover:w-8/12 border-warning"></div>
        </button>
      </footer> 
    </div>
  </div>
</template>
<script>
import { mapActions,mapState } from 'vuex';
import { required, minLength,email } from 'vuelidate/lib/validators'
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
        isLoading: false,
        resendIsLoading: false,
        userExists: false,
        resetStep: '1_reset_request',// '1_reset_request', '2_reset_authorization'
        userCanReset: false,
        resetToken: '',
        resetCode: '',
        countDownBeforeResend: 0,
      }
    },
    validations: {
      email:{
        required,
        email
      },
    },
    mounted() {
        document.title = this.$Lang_get('auth.reset_password')+" | "+process.env.MIX_APP_NAME;
    },
    methods: {
      ...mapActions('currentUser',['login','user_email_exists','resetPasswordRequest','authorizePasswordReset']),
      status(validation) {
        return {
          error: validation.$error,
          dirty: validation.$dirty
        }
      },
      checkIfExists(){
        this.$v.$touch();
        if (this.$v.$invalid) {
          return;
        }
        if (this.email) {
          let payload = {email: this.email};
          this.user_email_exists(payload).then(response => {
            if(response.data.user_exists){
              this.userExists = true; //user exists
            }
          }).catch(error => {
            this.userExists = false;
          })
        }
      },
      countDownTimer() {
          if(this.countDownBeforeResend > 0) {
              setTimeout(() => {
                  this.countDownBeforeResend -= 1
                  this.countDownTimer()
              }, 1000)
          }
      },
      resendResetPasswordRequest(){
        this.resendIsLoading = true;
        let payload = {email: this.email};
        this.resetPasswordRequest(payload).then(response => {
          if(response.status === 200){
            flash(response.data.message,'success');
            this.resetToken = response.data.token;
            this.countDownBeforeResend = 30;
            this.countDownTimer();
          } else {
            this.email = ''; 
            flash(this.$Lang_get('site_lang.server_error'),'error');
          }
          this.resendIsLoading = false;
        }).catch(error => {
          this.resendIsLoading = false;
          this.resetStep = '1_reset_request';
          this.email = '';
          this.resetToken = '';
          flash(error.response.data.errors.error[0], 'error');
        })
      },
      sendResetPasswordRequest(){
        this.$v.$touch();
        if (this.$v.$invalid) {
          return;
        }
        if(this.userExists) {
          this.isLoading = true;
          let payload = {email: this.email};
          this.resetPasswordRequest(payload).then(response => {
            if(response.status === 200){
              flash(response.data.message,'success');
              this.resetStep = '2_reset_authorization';
              this.resetToken = response.data.token;
            } else {
              this.email = ''; 
              flash(this.$Lang_get('site_lang.server_error'),'error');
            }
            this.isLoading = false;
          }).catch(error => {
            this.isLoading = false;
            this.resetStep = '1_reset_request';
            this.email = '';
            flash(error.response.data.errors.error[0], 'error');
          })
        }else{
          flash(this.$Lang_get('auth.failed'), 'error');
        }
      },
      verifyResetCode(){
        this.isLoading = true;
          const payload = {
            code: this.resetCode,
            token: this.resetToken,
          }
          this.authorizePasswordReset(payload).then(response=>{
              if(response.status===200){
                this.$router.push({ name: 'password-change', params: { email: this.email, code: this.resetCode, token: this.resetToken } })
              } else {
                this.resetCode = '';
                flash(this.$Lang_get('site_lang.server_error'),'error');
              }
              this.isLoading = false;
          }).catch(error=>{
              this.isLoading = false;
              this.resetCode = '';
              flash(error.response.data.errors.error[0], 'error');
          })
      }
    },
}
</script>