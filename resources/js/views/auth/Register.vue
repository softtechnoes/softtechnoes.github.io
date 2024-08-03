<template>
  <div class="container h-full px-4 mx-auto">
    <div class="flex items-center content-center justify-center h-full">
      <div class="w-full px-4 lg:w-6/12">
        <div
          class="relative flex flex-col w-full min-w-0 mb-6 break-words border-0 rounded-lg shadow-lg bg-blueGray-200"
        >
          <div class="px-6 py-6 mb-0 rounded-t">
            <div class="mb-3 text-center">
              <h6 class="text-sm font-bold text-blueGray-500">Sign up with</h6>
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
              <small>Or sign up with credentials</small>
            </div>
            <form>
              <div class="relative w-full mb-3">
                <label
                  class="block mb-2 text-xs font-bold uppercase text-blueGray-600"
                  htmlFor="grid-password"
                >
                  Name
                </label>
                <input v-model="v$.name.$model" type="text" @keyup.enter="handlesubmit" :class="status(v$.name)" class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring" :placeholder="$Lang_get('auth.name')">
                <div v-for="error of v$.name.$errors" :key="error.$uid" class="pt-2 pl-2 text-xs text-danger" >
                  <span class="captalize"> {{ error.$message }}</span>
                </div>
              </div>

              <div class="relative w-full mb-3">
                <label
                  class="block mb-2 text-xs font-bold uppercase text-blueGray-600"
                  htmlFor="grid-password"
                >
                  Email
                </label>
                <input v-model="v$.email.$model" @change="checkIfExists"  type="text" @keyup.enter="handlesubmit" :class="status(v$.email)" class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring" :placeholder="$Lang_get('auth.email')">
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
                <input v-model="v$.password.$model" type="password" @keyup.enter="handlesubmit" :class="status(v$.password)" class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring" :placeholder="$Lang_get('auth.password')">
                <div v-if="v$.password.$dirty" class="pt-2 pl-2 text-xs text-danger">
                  <p class="" v-if="!v$.password.required">{{$Lang_get('validation.required', {'attribute' : $Lang_get('validation.attributes.password')}) }}</p>
                </div>
                <div v-for="error of v$.password.$errors" :key="error.$uid" class="pt-2 pl-2 text-xs text-danger" >
                  <span class="captalize"> {{ error.$message }}</span>
                </div>
              </div>
              <div class="relative w-full mb-3">
                <label
                  class="block mb-2 text-xs font-bold uppercase text-blueGray-600"
                  htmlFor="grid-password"
                >
                  Confirm password
                </label>
                <input v-model="v$.password_conf.$model" type="password" @keyup.enter="handlesubmit" :class="status(v$.password_conf)" class="w-full px-3 py-3 text-sm transition-all duration-150 ease-linear bg-white border-0 rounded shadow placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring" :placeholder="$Lang_get('auth.password_conf')">
                <div v-for="error of v$.password_conf.$errors" :key="error.$uid" class="pt-2 pl-2 text-xs text-danger" >
                  <span class="captalize"> {{ error.$message }}</span>
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
                    I agree with the
                    <a href="javascript:void(0)" class="text-emerald-500">
                      Privacy Policy
                    </a>
                  </span>
                </label>
              </div>

              <div class="mt-6 text-center">
                <button
                  class="w-full px-6 py-3 mb-1 mr-1 text-sm font-bold uppercase transition-all duration-150 ease-linear rounded shadow outline-none bg-blueGray-800 active:bg-blueGray-600 hover:shadow-lg focus:outline-none"
                  type="button" @click="handlesubmit"
                >
                  Create Account
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
import { required, minLength, email, helpers, sameAs } from '@vuelidate/validators'
import useVuelidate from "@vuelidate/core";

export default {
  data() {
    return {
      github: "/assets/img/github.svg",
      google : "/assets/img/google.svg",
      logo_src: "/assets/img/logo" + process.env.MIX_CLIENT_CODE + ".svg",
      bg_src: "/assets/img/city.svg",
      name: "",
      email: "",
      password: "",
      password_conf: "",
      passwordConfirm: "",
      isLoading: false,
      userExists: false,
    };
  },
  setup() {
      return { v$: useVuelidate() };
  },
  // validations: {
  //   email: {
  //     required,
  //     email,
  //   },
  //   name: {
  //     required,
  //   },
  //   password: {
  //     required,
  //     minLength: minLength(8),
  //   },
  //   password_conf: { required, sameAsPassword: sameAs("password") },
  // },
  validations () {
    return {
      name: {
        required: helpers.withMessage(this.$Lang_get('validation.required', {'attribute' : this.$Lang_get('validation.attributes.name')}), required)
      },
      email: { 
        email: helpers.withMessage(this.$Lang_get('validation.email', {'attribute' : this.$Lang_get('validation.attributes.email')}) , email),
        required: helpers.withMessage(this.$Lang_get('validation.required', {'attribute' : this.$Lang_get('validation.attributes.email')}), required)
      },
      password: { 
        required: helpers.withMessage(this.$Lang_get('validation.required', {'attribute' : this.$Lang_get('validation.attributes.password')}), required),
        minLength: minLength(6)
       },
      password_conf: { 
        required: helpers.withMessage(this.$Lang_get('validation.required', {'attribute' : this.$Lang_get('validation.attributes.password')}), required),
        sameAsPassword: sameAs(this.password),
        $lazy: true
       },
      //  password_confold: {
      //   required: helpers.withMessage(
      //     "Confirm password cannot be empty. ",
      //     required
      //   ),
      //   sameAsPassword: helpers.withMessage(
      //     "Confirm password must be same as password you entered above.",
      //     sameAs(this.password)
      //   ),
      //   $lazy: true
      // },
    }
  },
  mounted() {
    document.title =
      this.$Lang_get("auth.register") + " | " + process.env.MIX_APP_NAME;
  },
  methods: {
    ...mapActions("currentUser", ["register", "user_email_exists"]),
    status(validation) {
      return {
        error: validation.$error,
        dirty: validation.$dirty,
      };
    },
    checkIfExists() {
      // This is called after the user updates the email box, and stores a variable in the data: userExists
      let payload = { email: this.email };
      this.user_email_exists(payload)
        .then((response) => {
          if (response.data.user_exists) {
            //user exists
            this.userExists = true;
            // flash(this.$Lang_get("auth.email_exists"), "error");
            this.$swal({
              text: this.$Lang_get('auth.email_exists'),
              showConfirmButton: false,
              position: 'top-end',
              icon: "error", // error, info, warning, success
              timer: 2000
            });
            this.email = "";
          }
        })
        .catch((error) => {
          this.userExists = false;
        });
    },
    handlesubmit() {
      this.v$.$touch();
      if (this.v$.$invalid) {
        return;
      }
      if (!this.userExists) {
        this.isLoading = true;
        const data = {
          name: this.name,
          email: this.email,
          password: this.password,
        };
        this.register(data)
          .then((response) => {
            if (response.status === 200) {
              this.isLoading = false;
              // flash(response.data.message, "success");
              this.$swal({
                text: response.data.message,
                showConfirmButton: false,
                position: 'top-end',
                icon: "success", // error, info, warning, success
                timer: 2000
              });
              setTimeout(() => {
                this.$router.push("/login");
              }, 3000);
              this.resetForm();
            } else {
              // flash(response.data.message, "error");
              this.$swal({
                text: response.data.message,
                showConfirmButton: false,
                position: 'top-end',
                icon: "error", // error, info, warning, success
                timer: 2000
              });
            }
          })
          .catch((error) => {
            this.isLoading = false;
            if (error.response.status === 500) {
              // flash(this.$Lang_get("site_lang.server_error"), "error");
              this.$swal({
                text: this.$Lang_get("site_lang.server_error"),
                showConfirmButton: false,
                position: 'top-end',
                icon: "error", // error, info, warning, success
                timer: 2000
              });
            } else {
              this.$swal({
                text: error.response.data.errors.error[0],
                showConfirmButton: false,
                position: 'top-end',
                icon: "success", // error, info, warning, success
                timer: 2000
              });
              // flash(error.response.data.errors.error[0], "error");
            }
          });
      }
    },
    resetForm() {
      this.name = "";
      this.email = "";
      this.password = "";
      this.password_conf = "";
    },
  },
};
</script>
