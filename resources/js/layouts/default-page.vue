<template>
  <div >
    <navbar />
    <main class="bg-gray-200">
      <section class="relative w-full h-full min-h-screen py-40">
            <router-view v-slot="{ Component }">
            <transition
                enter-active-class="transition-all duration-1000 ease-out delay-500"
                leave-active-class="transition-all duration-1000 ease-in delay-500"
                enter-class="opacity-0 scale-70"
                enter-to-class="scale-100 opacity-100"
                leave-class="scale-100 opacity-100"
                leave-to-class="opacity-0 scale-70"
                mode="out-in"
                name="fade"
            >
                <component :is="Component" />
            </transition>
            </router-view>
            </section>
            </main>
  </div>
</template>

<script>
import Navbar from "../components/Navbars/RetroNavbar.vue";

export default {
  methods: {},
  components: {
        Navbar,
  },
  data() {
    return {
      registerBg2: "/assets/img/register_bg_2.png",
    };
  },
};
</script>
