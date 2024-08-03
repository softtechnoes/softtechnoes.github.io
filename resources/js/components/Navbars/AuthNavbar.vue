<template>
  <nav
    class="absolute top-0 z-50 flex flex-wrap items-center justify-between w-full px-2 py-3 navbar-expand-lg"
  >
    <div
      class="container flex flex-wrap items-center justify-between px-4 mx-auto"
    >
      <div
        class="relative flex justify-between w-full lg:w-auto lg:static lg:block lg:justify-start"
      >
        <router-link
          class="inline-block py-2 mr-4 text-sm font-bold leading-relaxed text-white uppercase whitespace-nowrap"
          to="/"
        >
          {{appName}}
        </router-link>
        <button
          class="block px-3 py-1 text-xl leading-none bg-transparent border border-transparent border-solid rounded outline-none cursor-pointer lg:hidden focus:outline-none"
          type="button"
          v-on:click="setNavbarOpen"
        >
          <i class="text-white fas fa-bars"></i>
        </button>
      </div>
      <div
        class="items-center flex-grow bg-white lg:flex lg:bg-opacity-0 lg:shadow-none"
        :class="[navbarOpen ? 'block rounded shadow-lg' : 'hidden']"
        id="example-navbar-warning"
      >
        <ul class="flex flex-col mr-auto list-none lg:flex-row">
          <li class="flex items-center" v-if="env === 'local'">
            <a
              class="flex items-center px-3 py-4 text-xs font-bold uppercase lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 lg:py-2"
              href="https://www.creative-tim.com/learning-lab/tailwind/vue/overview/notus?ref=vn-auth-navbar"
            >
              <i
                class="mr-2 text-lg lg:text-blueGray-200 text-blueGray-400 far fa-file-alt leading-lg"
              />
              Docs
            </a>
          </li>
        </ul>
        <ul class="flex flex-col list-none lg:flex-row lg:ml-auto">
          <li class="flex items-center">
            <a
              class="flex items-center px-3 py-4 text-xs font-bold uppercase lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 lg:py-2"
              href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdemos.creative-tim.com%2Fvue-notus%2F%23%2F"
              target="_blank"
            >
              <i
                class="text-lg lg:text-blueGray-200 text-blueGray-400 fab fa-facebook leading-lg"
              />
              <span class="inline-block ml-2 lg:hidden">Share</span>
            </a>
          </li>

          <li class="flex items-center">
            <a
              class="flex items-center px-3 py-4 text-xs font-bold uppercase lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 lg:py-2"
              href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fdemos.creative-tim.com%2Fvue-notus%2F%23%2F&text=Start%20your%20development%20with%20a%20Free%20Tailwind%20CSS%20and%20VueJS%20UI%20Kit%20and%20Admin.%20Let%20Vue%20Notus%20amaze%20you%20with%20its%20cool%20features%20and%20build%20tools%20and%20get%20your%20project%20to%20a%20whole%20new%20level.%20"
              target="_blank"
            >
              <i
                class="text-lg lg:text-blueGray-200 text-blueGray-400 fab fa-twitter leading-lg"
              />
              <span class="inline-block ml-2 lg:hidden">Tweet</span>
            </a>
          </li>

          <li class="flex items-center">
            <a
              class="flex items-center px-3 py-4 text-xs font-bold uppercase lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 lg:py-2"
              href="https://github.com/creativetimofficial/vue-notus?ref=vn-auth-navbar"
              target="_blank"
            >
              <i
                class="text-lg lg:text-blueGray-200 text-blueGray-400 fab fa-github leading-lg"
              />
              <span class="inline-block ml-2 lg:hidden">Star</span>
            </a>
          </li>

          <li class="flex items-center">
            <router-link to="/login"
              class="px-4 py-2 mb-3 ml-3 text-xs font-bold uppercase transition-all duration-150 ease-linear bg-white rounded shadow outline-none text-blueGray-700 active:bg-blueGray-50 hover:shadow-md focus:outline-none lg:mr-1 lg:mb-0"
              type="button"
            >
            Login <i class="fas fa-arrow-right"></i> 
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
// import PagesDropdown from "../Dropdowns/PagesDropdown.vue";
export default {
  data() {
    return {
      navbarOpen: false,
      appName: process.env.MIX_APP_NAME,
      env: process.env.MIX_APP_ENV,
    };
  },
  methods: {
    setNavbarOpen: function () {
      this.navbarOpen = !this.navbarOpen;
    },
  },
  components: {
    
  },
};
</script>
