<template>

<div>
    <navbar />
    <main>
      <section class="relative w-full h-full min-h-screen py-40">
        <div
          class="absolute top-0 w-full h-full bg-no-repeat bg-blueGray-800 bg-full"
          :style="`background-image: url('${registerBg2}');`"
        ></div>
        
          <router-view v-slot="{ Component }"> 
            <transition 
              enter-active-class="transition-all duration-1000 ease-out delay-500"    
              leave-active-class="transition-all duration-1000 ease-in delay-500"
              enter-class="opacity-0 scale-70"
              enter-to-class="scale-100 opacity-100"
              leave-class="scale-100 opacity-100"
              leave-to-class="opacity-0 scale-70"
              mode="out-in" name="fade" 
            >
              <component :is="Component" />
            </transition>
          </router-view>
        <footer-small absolute />
      </section>
      <session-alert></session-alert>
    </main>
  </div>
  
</template>

<script>
    // import SessionAlert from '../components/alerts/SessionAlert.vue';
    import Navbar from "../components/Navbars/AuthNavbar.vue";
    import FooterSmall from "../components/Footers/FooterSmall.vue";

    export default {
        components: {
            Navbar,
            FooterSmall,
        },
        methods : {
        },
        data() {
            return {
                registerBg2: "/assets/img/register_bg_2.png",
            };
        },
        mounted() {
            
        },
        watch: {
        },
        
        destroyed(){
        }
    }
</script>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

