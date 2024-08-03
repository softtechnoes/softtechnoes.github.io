<template>
  <div>
    <div class="fixed inset-0 z-40 opacity-75 bg-secondary focus:outline-none"></div>
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
      <div class="relative w-11/12 lg:w-1/4">
        <!--content-->
        <div class="relative flex flex-col w-full p-4 border-0 rounded-lg shadow-lg outline-none bg-background focus:outline-none" @click.stop>
          <!--header-->
          <div class="flex flex-col items-center w-full">
            <div class="flex items-center justify-center w-full text-center">
              <svg class="w-6 h-6 text-danger" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="iconPath" />
              </svg>
              <span class="text-lg font-medium leading-6 text-secondary">{{title}}</span>
            </div>
          </div>
          <!--body-->
          <div class="flex flex-col items-center w-full mt-4 lg:mt-8">
              <p class="text-sm text-gray-500">
                {{message}}
              </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
    data() {
      return {
      }
    },
    props: {
        title: {
            type: String,
            default: ''
        },
        message: {
            type: String,
            default: ''
        },
        iconPath: {
          type: String,
          default: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        }
    },
    computed:{
    },
    methods: {
        ...mapActions('currentUser',['sendActivationEmail']),
        closeModal(){
          this.$emit('hideModal');
        },
         
    },
}
</script>