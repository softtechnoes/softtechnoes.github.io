<template>
    <Transition name="fade">
        <div @key.esc="closeModal()">
            <div v-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
                <div class="relative w-auto max-w-3xl mx-auto my-6">
                <!--content-->
                <div class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                    <h3 class="text-3xl font-semibold">
                        Modal Title
                    </h3>
                    <button class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none opacity-5 focus:outline-none" v-on:click="closeModal()">
                        <span class="block w-6 h-6 text-2xl text-black bg-transparent outline-none opacity-5 focus:outline-none">
                        ×
                        </span>
                    </button>
                    </div>
                    <!--body-->
                    <div class="relative flex-auto p-6">
                        <div class="flex flex-col items-center w-full px-4 mt-4 lg:mt-8 lg:px-16">
                            <span class="w-full pb-6">{{$Lang_get('auth.account_deactivated_expl')}}</span>
                            <div class="flex flex-col w-full">
                                <span class="pb-4 text-secondary">{{$Lang_get('auth.activation_expl')}}</span>
                                <loader v-if="isLoading" :message="$Lang_get('auth.loading')"/>
                                <div v-if="!isLoading" class="flex flex-col items-center w-full">
                                <button @click="sendActivationCode" v-if="countDownBeforeResend === 0" type="button" class="relative flex justify-center w-10/12 px-2 py-2 border-2 rounded-lg lg:w-6/12 lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white">
                                    {{$Lang_get('auth.resend_activation')}} 
                                </button>  
                                <span v-if="countDownBeforeResend === 0" class="pt-2 text-secondary">{{email}}</span>
                                <div v-if="countDownBeforeResend > 0" class="flex flex-col items-center text-secondary">
                                    <span class="">{{$Lang_get('auth.resend_wait')}}</span>
                                    <span class="text-2xl">{{countDownBeforeResend}}</span>    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                    <button class="px-6 py-2 mb-1 mr-1 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear outline-none background-transparent focus:outline-none" type="button" v-on:click="closeModal()">
                        Close
                    </button>
                    <button class="px-6 py-3 mb-1 mr-1 text-sm font-bold text-white uppercase transition-all duration-150 ease-linear rounded shadow outline-none bg-emerald-500 active:bg-emerald-600 hover:shadow-lg focus:outline-none" type="button" v-on:click="closeModal()">
                        Save Changes
                    </button>
                    </div>
                </div>
                </div>
            </div>
            <div v-show="showModal" class="fixed inset-0 z-40 bg-black opacity-25"></div>
        </div>
    </Transition>
  </template>
  
  <script>
  import { mapActions } from 'vuex';
import loader from '../reusables/loader.vue';
  export default {
    name: "regular-modal",
    components: {
      loader
    },
    data() {
      return {
        countDownBeforeResend: 0,
        isLoading: false,
      }
    },
    props: {
        showModal: {
            type: Boolean,
            default: false
        },
        email: {
            type: String,
            required: true
        },
    },
    computed:{
        canActivate(){
            let boolVal = false;
            if(this.activationCode.trim() !== ''){
                boolVal = true;
            }
            return boolVal;
        }
    },
    methods: {
        ...mapActions('currentUser',['sendActivationEmail']),
        closeModal(){
            this.$emit('closeModal', false);
        },
        countDownTimer() {
            if(this.countDownBeforeResend > 0) {
                setTimeout(() => {
                    this.countDownBeforeResend -= 1
                    this.countDownTimer()
                }, 1000)
            }
        },
        sendActivationCode(){
          this.isLoading = true;
          let payload = {email: this.email};
          this.sendActivationEmail(payload).then(response => {
            if(response.data.status === 200){
              // flash(response.data.message, 'success');
              this.$swal({
                text: response.data.message,
                showConfirmButton: false,
                position: 'top-end',
                icon: "success", // error, info, warning, success
                timer: 2000
              });
              this.countDownBeforeResend = 30;
              this.countDownTimer();
              this.isLoading = false; 
            }
          })
        }
         
    },
  }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
    transition: all 0.4s;
    }
    .fade-enter,
    .fade-leave-to {
    opacity: 0;
    }
</style>