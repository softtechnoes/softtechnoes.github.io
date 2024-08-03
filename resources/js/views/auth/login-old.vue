<template>
  <div class="w-full min-h-screen">
    <div class="fixed bottom-0 right-0 z-0 flex content-center w-full h-screen bg-cover bg-background">
        <img :src="bg_src" class="self-center w-full"/>
    </div>
    <div class="container flex flex-col min-h-screen px-8 py-20 lg:px-2">
      <div class="flex justify-start w-full">
          <img :src="logo_src" class="z-10 self-center h-12 lg:h-40"/>
      </div>
      
      <div class="z-10 flex flex-col items-center justify-center flex-grow w-full">
        <div class="flex flex-col items-center w-10/12 px-8 py-12 rounded-lg lg:py-16 lg:px-16 sm:w-10/12 md:w-8/12 lg:w-5/12 bg-tertiary">
          <span class="w-full text-lg font-bold text-center">{{$Lang_get('auth.login_title')}}</span>
          <!-- {{ v$.email.$errors }} - {{ v$.email.$errors.length }} -->
          <!-- <p
            v-for="error of v$.email.$errors"
            :key="error.$uid"
          >
          <strong>{{ error.$validator }}</strong>
          <small> on property</small>
          <strong>{{ error.$property }}</strong>
          <small> says:</small>
          <strong>{{ error.$message }}</strong>
          </p> -->
          <div class="flex flex-col w-full my-8 text-sm" v-if="countDownOnTooManyLoginAttemptsLockout === 0">
            <div class="flex justify-center my-3">
              <svg class="h-4 my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              <input @keyup.enter="handlesubmit" @change="checkIfExists" v-model="v$.email.$model" type="email" autocomplete="email" :class="status(v$.email)" class="w-full h-8 ml-2 border form-input" :placeholder="$Lang_get('auth.email')">
            </div>
            <!-- <div v-if="v$.email.$errors" class="pl-2 text-xs text-danger">
                <p class="ml-6" v-if="!v$.email.$email">{{$Lang_get('validation.email', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
                <p class="ml-6" v-if="!v$.email.$required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
            </div> -->

            <div v-for="error of v$.email.$errors"
              :key="error.$uid" class="pl-2 text-xs text-danger" >
              <span class="pl-5 captalize"> {{ error.$message }}</span>
            </div>
            <div class="flex justify-center my-3">
              <svg class="h-4 my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
              <input type="password" @keyup.enter="handlesubmit" v-model="v$.password.$model" autocomplete="current-password" :class="status(v$.password)" class="w-full h-8 ml-2 border form-input" :placeholder="$Lang_get('auth.password')" >
            </div>
            <div v-if="v$.password.$dirty" class="pl-2 text-xs text-danger">
              <p class="ml-6" v-if="!v$.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
            </div>
          </div>
          <div class="flex items-center justify-center w-8/12 text-center lg:w-3/4 md:w-1/2" v-if="countDownOnTooManyLoginAttemptsLockout === 0">
            <loader v-if="isLoading" :message="$Lang_get('auth.loading')"/>
            <button v-else class="relative flex justify-center w-full px-2 py-1 text-lg font-bold border-2 rounded-lg lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white" @click="handlesubmit">
              {{$Lang_get('auth.login')}}
            </button>
          </div>
          <div class="flex flex-col items-center w-full my-8 text-center" v-if="countDownOnTooManyLoginAttemptsLockout > 0">
            <span class="text-xl">{{$Lang_get('auth.throttle_expl')}}</span>
            <span class="my-3 text-2xl">{{countDownOnTooManyLoginAttemptsLockout}}</span>
            <router-link to="/forgot-password" exact><span class="w-full">{{ $Lang_get('auth.forgot_password_reset') }}</span></router-link>
          </div>
        </div>
      </div>
      <footer class="flex items-center justify-between pb-10 text-sm md:text-md lg:text-lg">
        <button class="z-10 flex flex-col items-center justify-center text-center focus:outline-none group">
          <router-link to="/forgot-password" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.forgot_password') }}</span></router-link>
          <div class="w-full mt-1 border-t-8 rounded-md group-hover:w-8/12 border-tertiary"></div>
        </button>
        <button class="z-10 flex flex-col items-center justify-center text-center focus:outline-none group">
          <router-link to="/register" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.register') }}</span></router-link>
          <div class="w-full mt-1 border-t-8 rounded-md group-hover:w-8/12 border-warning"></div>
        </button>
      </footer> 
    </div>
    <ActivateUserAccountModal :email="this.email" @hideModal="hideUserActivationModal()" v-if="showUserActivationModal"/>
  </div>
</template>
<script>
import { mapActions,mapState } from 'vuex';
import ActivateUserAccountModal from '../../components/auth/ActivateUserAccountModal';
import { required, minLength, email, helpers } from '@vuelidate/validators'
import loader from '../../components/reusables/loader.vue';
import useVuelidate from "@vuelidate/core";

export default {
    components: {
      ActivateUserAccountModal,
      loader,
	  },
    data() {
      return {
        logo_src: '/assets/img/logo/kt-pink-tr.png',
        bg_src: '/assets/img/city.svg',
        email:'',
        password:'',
        isLoading: false,
        userExists: false,
        showUserActivationModal: false,
        countDownOnTooManyLoginAttemptsLockout: 0,
      }
    },
    setup() {
        return { v$: useVuelidate() };
    },
    validations () {
      return {
        email: { 
          email: helpers.withMessage(this.$Lang_get('validation.email', {'attribute' : this.$Lang_get('validation.attributes.email')}) , email),
          required: helpers.withMessage(this.$Lang_get('validation.required', {'attribute' : this.$Lang_get('validation.attributes.email')}), required)
        },
        password: { required }
      }
    },
    // validations: {
    //   email:{
    //     required,
    //     email,
    //   },
    //   password:{
    //     required,
    //   }
    // },
    mounted() {
        document.title = this.$Lang_get('auth.login_title')+" | "+process.env.MIX_APP_NAME;
        
        // In case there is a redirectPath present, inform the user that he needs to authenticate
        if(this.$route.query.redirectPath){
          this.$swal({
            text: this.$Lang_get('auth.auth_required'),
            showConfirmButton: false,
            position: 'top-end',
            icon: "warning", // error, info, warning, success
            timer: 2000
          });
        }
        // Check if email already provided
        if(this.$route.query.email){
          this.email = this.$route.query.email;
          this.userExists = true;
        }
    },
    computed: {
      canSendLoginRequest(){
        if(this.email && this.password) {
          return true
        }else{
          return false
        }  
      }
    },
    methods: {
      ...mapActions('currentUser',['login','user_email_exists','test']),
      status(validation) {
        return {
          error: validation.$error,
          dirty: validation.$dirty
        }
      },
      checkIfExists(){
        // This is called after the user updates the email box, and stores a variable in the data: userExists
        let payload = {email: this.email};
        this.user_email_exists(payload).then(response => {
          if(response.data.user_exists){
            //user exists
            this.userExists = true;
          }
        }).catch(error => {
          this.userExists = false;
        })
      },
      handlesubmit(){
        // If data userExists is false, flash error, otherwise do request
        this.v$.$touch();
        if (this.v$.$invalid) {
          console.log('invalid')
          return;
        }
        if(this.userExists) {
          this.isLoading = true;
          const data = {
            email: this.email,
            password: this.password,
          }
          this.login(data).then(response => {
            if(response){
              localStorage.setItem('auth_token', response.data.token);
              axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
              this.isLoading = false;
              const intendedPath = this.$route.query.redirectPath;
              if(intendedPath){
                this.$router.push(intendedPath).catch(()=>{});
              }else{
                this.$router.push("/dashboard").catch(()=>{});
              }              
            }
          }).catch(error => {
            this.isLoading = false;
            if(error.response.status === 422){
              // if user is not activated 
              if(error.response.data.errors.error[0] === this.$Lang_get('auth.account_deactivated')){
                this.isLoading = false;
                this.showUserActivationModal = true;
              }else{
                // if incorrect password 
                this.isLoading = false;
                this.$swal({
                  text: error.response.data.errors.message[0],
                  showConfirmButton: false,
                  position: 'top-end',
                  icon: "error", // error, info, warning, success
                  timer: 2000
                });
                
              }
            }else if(error.response.status === 429){
              // throttle error
              let message = error.response.data.errors.email[0];
              this.$swal({
                text: message,
                showConfirmButton: false,
                position: 'top-end',
                icon: "error", // error, info, warning, success
                timer: 2000
              });
              // Countdown
              let messageArray = message.split(' ');
              let waitIndex = messageArray.findIndex((element) => element.indexOf('second') > -1);
              this.countDownOnTooManyLoginAttemptsLockout = messageArray[waitIndex-1];
              this.countDownTimer();
            }
          })
        }else{
          // flash(this.$Lang_get('auth.failed'), 'error');
          this.$swal({
            text: this.$Lang_get('auth.failed'),
            showConfirmButton: false,
            position: 'top-end',
            icon: "error", // error, info, warning, success
            timer: 2000
          });
        }
      },
      hideUserActivationModal(){
        this.showUserActivationModal = false;
      },
      countDownTimer() {
        if(this.countDownOnTooManyLoginAttemptsLockout > 0) {
            setTimeout(() => {
                this.countDownOnTooManyLoginAttemptsLockout -= 1
                this.countDownTimer()
            }, 1000)
        }
      },
    },
}
</script>
