<template>
  <div @click="closeModal()" @key.esc="closeModal()">
    <div class="fixed inset-0 z-40 opacity-75 bg-secondary focus:outline-none"></div>
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
      <div class="relative w-11/12 lg:w-9/12 xl:w-6/12">
        <!--content-->
        <div class="relative flex flex-col w-full px-4 py-8 border-0 rounded-lg shadow-lg outline-none bg-background focus:outline-none" @click.stop>
          <!--header-->
          <div class="flex flex-col items-center w-full">
            <div class="flex justify-end w-full">
              <svg class="self-center w-5 h-5 cursor-pointer fill-current text-secondary hover:text-danger" @click="closeModal()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
              </svg>
            </div>
            <div class="flex items-center justify-center w-full text-center">
              <svg class="w-6 h-6 mr-4 text-danger" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span class="text-lg font-medium leading-6">{{$Lang_get('auth.account_deactivated')}}</span>
            </div>
          </div>
          <!--body-->
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
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
import loader from '../reusables/loader.vue';
export default {
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
          this.$emit('hideModal');
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