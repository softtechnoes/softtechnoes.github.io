<!-- AttractiveLoginPage.vue -->

<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-teal-500 to-cyan-500">
      <div class="w-full max-w-md p-8 bg-white rounded-md shadow-md">
        <h1 class="mb-6 text-3xl font-bold text-center text-teal-500">AwesomeApp</h1>
  
        <!-- Login Form -->
        <div class="space-y-4">
          <div>
            <input @keyup.enter="handlesubmit" @change="checkIfExists" v-model="v$.email.$model" type="email" autocomplete="email" :class="status(v$.email)" class="w-full p-2 border-2 border-teal-500 rounded-md focus:outline-none focus:border-cyan-500" :placeholder="$Lang_get('auth.email')">
            <div v-for="error of v$.email.$errors" :key="error.$uid" class="pt-2 pl-2 text-xs text-danger" >
              <span class="captalize"> {{ error.$message }}</span>
            </div>
          </div>
  
          <div>
            <input type="password" @keyup.enter="handlesubmit" v-model="v$.password.$model" autocomplete="current-password" :class="status(v$.password)" class="w-full p-2 border-2 border-teal-500 rounded-md focus:outline-none focus:border-cyan-500" :placeholder="$Lang_get('auth.password')" >
            <div v-if="v$.password.$dirty" class="pt-2 pl-2 text-xs text-danger">
              <p class="" v-if="!v$.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
            </div>
          </div>
  
          <button
            type="submit"
            class="w-full py-2 font-bold text-white transition duration-300 bg-teal-500 rounded-full hover:bg-cyan-500" @click="handlesubmit"
          >
            Log In
          </button>
        </div>
  
        <!-- Additional Options -->
        <div class="mt-4 text-center">
          <a href="#" class="text-sm text-teal-500 hover:underline">Forgot Password?</a>
          <span class="mx-2 text-gray-500">|</span>
          <router-link to="/signup" class="text-sm text-teal-500 hover:underline">Create an Account</router-link>
        </div>
      </div>
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
      ...mapActions('currentUser',['login','user_email_exists']),
      status(validation) {
        return {
          error: validation.$error,
          dirty: validation.$dirty
        }
      },
      checkIfExists(){
        // This is called after the user updates the email box, and stores a variable in the data: userExists
        let payload = {email: this.email};
        console.log(payload)
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
            console.log(response);
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
            console.log(error);
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
