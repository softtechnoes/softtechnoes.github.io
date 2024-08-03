<template>
  <div class="container h-full px-4 mx-auto" >
    <div class="flex items-center content-center justify-center h-full">
      <div class="w-full px-4 lg:w-4/12">
        <div
          class="relative flex flex-col w-full min-w-0 mb-6 break-words border-0 rounded-lg shadow-lg bg-blueGray-200"
        >
          <div class="px-6 py-6 mb-0 rounded-t">
            <div class="mb-3 text-center">
              <h6 class="text-sm font-bold text-blueGray-500">
                Sign in with
              </h6>
            </div> 
            <div class="text-center btn-wrapper">
              <button
                class="inline-flex items-center px-4 py-2 mb-1 mr-2 text-xs font-normal font-bold uppercase transition-all duration-150 ease-linear bg-white rounded shadow outline-none active:bg-blueGray-50 text-blueGray-700 focus:outline-none hover:shadow-md"
                type="button"
              >
                <img alt="..." class="w-5 mr-1" :src="github" />
                Github
              </button>
              <button
                class="inline-flex items-center px-4 py-2 mb-1 mr-1 text-xs font-normal font-bold uppercase transition-all duration-150 ease-linear bg-white rounded shadow outline-none active:bg-blueGray-50 text-blueGray-700 focus:outline-none hover:shadow-md"
                type="button"
              >
                <img alt="..." class="w-5 mr-1" :src="google" />
                Google
              </button>
            </div>
            <hr class="mt-6 border-b-1 border-blueGray-300" />
          </div>
          <div class="flex-auto px-4 py-10 pt-0 lg:px-10">
            <div class="mb-3 font-bold text-center text-blueGray-400">
              <small>Or sign in with credentials</small>
            </div>
            <form>
              <div class="relative w-full mb-3">
                <label
                  class="block mb-2 text-xs font-bold uppercase text-blueGray-600"
                  htmlFor="grid-password"
                >
                  Email
                </label>
                <!-- <input
                  type="email"
                  class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring"
                  placeholder="Email"
                /> -->
                <input @keyup.enter="handlesubmit" @change="checkIfExists" v-model="v$.email.$model" type="email" autocomplete="email" :class="status(v$.email)" class="w-full p-2 border-2 border-teal-500 rounded-md focus:outline-none focus:border-cyan-500" :placeholder="$Lang_get('auth.email')">
            <div v-for="error of v$.email.$errors" :key="error.$uid" class="pt-2 pl-2 text-xs text-danger" >
              <span class="captalize"> {{ error.$message }}</span>
            </div>
              </div>

              <div class="relative w-full mb-3">
                <label
                  class="block mb-2 text-xs font-bold uppercase text-blueGray-600"
                  htmlFor="grid-password"
                >
                  Password
                </label>
                <!-- <input
                  type="password"
                  class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring"
                  placeholder="Password"
                /> -->
                <input type="password" @keyup.enter="handlesubmit" v-model="v$.password.$model" autocomplete="current-password" :class="status(v$.password)" class="w-full p-2 border-2 border-teal-500 rounded-md focus:outline-none focus:border-cyan-500" :placeholder="$Lang_get('auth.password')" >
            <div v-if="v$.password.$dirty" class="pt-2 pl-2 text-xs text-danger">
              <p class="" v-if="!v$.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
            </div>
              </div>
              <div>
                <label class="inline-flex items-center cursor-pointer">
                  <input
                    id="customCheckLogin"
                    type="checkbox"
                    class="w-5 h-5 ml-1 transition-all duration-150 ease-linear border-0 rounded form-checkbox text-blueGray-700"
                  />
                  <span class="ml-2 text-sm font-semibold text-blueGray-600">
                    Remember me
                  </span>
                </label>
              </div>

              <div class="mt-6 text-center">
                <button
                  class="w-full px-6 py-3 mb-1 mr-1 text-sm font-bold uppercase transition-all duration-150 ease-linear rounded shadow outline-none bg-blueGray-800 active:bg-blueGray-600 hover:shadow-lg focus:outline-none"
                  type="button" @click="handlesubmit"
                >
                  Sign In
                </button>                
              </div>
            </form>
          </div>
        </div>
        <div class="relative flex flex-wrap mt-6">
          <div class="w-1/2">
            <a href="javascript:void(0)" class="text-blueGray-200">
              <small>Forgot password?</small>
            </a>
          </div>
          <div class="w-1/2 text-right">
            <router-link to="/register" class="text-blueGray-200">
              <small>Create new account</small>
            </router-link>
          </div>
        </div>
      </div>
    </div>
    
    <!-- <GlobalModalVue :showModal="showGlobalModal" @closeModal="closeModal" :email="this.email" /> -->
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
  },
  data() {
    return {
      github: "/assets/img/github.svg",
      google : "/assets/img/google.svg",
      logo_src: '/assets/img/logo/kt-pink-tr.png',
      bg_src: '/assets/img/city.svg',
      email:'',
      password:'',
      isLoading: false,
      userExists: false,
      showUserActivationModal: false,
      countDownOnTooManyLoginAttemptsLockout: 0,
      showGlobalModal: true,
    };
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
      closeModal(value) {
        this.showGlobalModal = value;
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
                this.$router.push("/admin/dashboard").catch(()=>{});
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
};
</script>
