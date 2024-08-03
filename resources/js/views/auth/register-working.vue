<template>
<div class="w-full min-h-screen">
    <div class="fixed bottom-0 right-0 z-0 flex content-center w-full h-screen bg-cover bg-background">
        <img :src="bg_src" class="self-center w-full"/>
    </div>
    <div class="container flex flex-col min-h-screen px-8 py-20 lg:px-2">
        <div class="flex justify-start w-full">
            <img :src="logo_src" class="z-10 self-center h-12 lg:h-14"/>
        </div>
        <div class="z-10 flex flex-col items-center justify-center flex-grow w-full">
            <div class="flex flex-col items-center w-10/12 px-8 py-12 rounded-lg lg:py-16 lg:px-16 sm:w-10/12 md:w-8/12 lg:w-5/12 bg-tertiary">
                <span class="w-full text-lg font-bold text-center">{{$Lang_get('auth.register_title1')}}</span>
                <span class="w-full text-center">{{$Lang_get('auth.register_title2')}}</span>
                <div class="flex flex-col w-full my-8 text-sm">
                    <!-- Name  -->
                    <div class="flex justify-center">
                        <svg class="h-4 my-3" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <input v-model="$v.name.$model" type="text" @keyup.enter="handlesubmit" :class="status($v.name)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.name')">
                    </div>
                    <div v-if="$v.name.$dirty" class="text-danger">
                        <p class="ml-8" v-if="!$v.name.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.name')}) }}</p>
                    </div>
                    <!-- EMail  -->
                    <div class="flex justify-center my-3">
                        <svg class="h-4 mt-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <input @change="checkIfExists" v-model="$v.email.$model" @keyup.enter="handlesubmit" type="email" autocomplete="email" :class="status($v.email)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.email')">
                    </div>
                    <div v-if="$v.email.$dirty" class="text-danger">
                        <p class="ml-8" v-if="!$v.email.email">{{$Lang_get('validation.email', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
                        <p class="ml-8" v-if="!$v.email.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.email')}) }}</p>
                    </div>
                    <!-- Password  -->
                    <div class="flex justify-center my-3"> 
                        <svg class="h-4 mt-1" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                        <input type="password" v-model="$v.password.$model" @keyup.enter="handlesubmit" autocomplete="current-password" :class="status($v.password)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.password')" >
                    </div>
                    <div v-if="$v.password.$dirty" class="text-danger">
                        <p class="ml-8" v-if="!$v.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
                        <p class="ml-8" v-if="!$v.password.minLength">{{$Lang_get('passwords.password')}}</p>
                    </div>
                    <!-- Confirm password  -->
                    <div class="flex justify-center my-3">
                        <svg class="h-4 mt-1" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                        <input type="password" v-model="$v.password_conf.$model" @keyup.enter="handlesubmit" autocomplete="current-password" :class="status($v.password_conf)" class="w-full h-8 ml-1 bg-transparent border rounded-lg placeholder-secondary border-primary form-input" :placeholder="$Lang_get('auth.confirm_password')" >
                    </div>
                    <div v-if="$v.password_conf.$dirty" class="text-danger">
                        <div class="ml-8" v-if="!$v.password_conf.sameAsPassword">{{$Lang_get('validation.same', {'attribute' : $Lang_get('validation.attributes.password'), 'other' : $Lang_get('validation.attributes.password_confirmation')}) }}</div>
                    </div>
                </div>
                <div class="flex items-center justify-center w-8/12 text-center lg:w-3/4 md:w-1/2">
                    <div class="flex ml-4 space-x-2 animate-pulse" v-if="isLoading" >  
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                    </div>
                    <button v-else class="relative flex justify-center w-full px-2 py-1 text-lg font-bold border-2 rounded-lg lg:px-4 lg:py-2 border-info hover:bg-info hover:text-white" @click="handlesubmit">
                        {{$Lang_get('auth.register')}}
                    </button>
                </div>
            </div>
        </div>
        <footer class="flex items-center justify-between pb-10 text-sm md:text-md lg:text-lg">
            <button class="z-10 flex flex-col items-center justify-center py-3 mr-24 text-center focus:outline-none group">
                <router-link to="/connexion" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.login') }}</span></router-link>
                <div class="w-full mt-2 border-t-8 rounded-md group-hover:w-8/12 border-tertiary"></div>
            </button>
            <button class="z-10 flex flex-col items-center justify-center text-center focus:outline-none group">
                <router-link to="/inscription" exact><span class="px-2 py-2 md:px-6">{{ $Lang_get('auth.register') }}</span></router-link>
                <div class="w-full mt-2 border-t-8 rounded-md group-hover:w-8/12 border-warning"></div>
            </button>
        </footer>
    </div>
</div>
</template>
<script>
import { mapActions } from 'vuex';
import { required, minLength, email, sameAs  } from 'vuelidate/lib/validators';
export default {
    components: {
        
	},
    data() {
        return {
            logo_src: '/assets/img/logo' + process.env.MIX_CLIENT_CODE + '.svg',
            bg_src: '/assets/img/city.svg',
            name:'',
            email:'',
            password:'',
            password_conf:'',
            isLoading: false,
            userExists: false,
        }
    },
    validations: {
      email:{
        required,
        email
      },
      name:{
        required,
      },
      password:{
        required,
        minLength: minLength(8)
      },
      password_conf: { required, sameAsPassword: sameAs('password') }
    },
    mounted() {
        document.title = this.$Lang_get('auth.register')+" | "+process.env.MIX_APP_NAME;
    },
    methods: {
        ...mapActions('currentUser',['register','user_email_exists']),
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
                flash(this.$Lang_get('auth.email_exists'), 'error');
                this.email = '';
            }
            }).catch(error => {
                this.userExists = false;
            })
        },
        handlesubmit(){
            this.$v.$touch();
            if (this.$v.$invalid) { return; }
            if(!this.userExists) {
                this.isLoading = true;
                const data = {
                    name        : this.name,
                    email       : this.email,
                    password    : this.password,
                }
                this.register(data).then(response =>{
                    if(response.status === 200){
                        this.isLoading = false;
                        flash(response.data.message, 'success');
                        setTimeout(() => {
                            this.$router.push("/connexion");
                        }, 3000)
                        this.resetForm();
                    } else {
                        flash(response.data.message, 'error');
                    }
                }).catch(error=>{
                    this.isLoading = false;
                    if(error.response.status === 500){
                        flash(this.$Lang_get('site_lang.server_error'),'error');
                    }else{
                        flash(error.response.data.errors.error[0], 'error');
                    }  
                })
            }
        },
        resetForm(){
            this.name = '';
            this.email = '';
            this.password = '';
            this.password_conf = '';
        }
    }
}
</script>
