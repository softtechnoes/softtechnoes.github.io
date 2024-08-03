<template>
    <!-- <router-view v-slot="{ Component }">
        <transition 
            enter-active-class="transition-all duration-1000 ease-out delay-500"    
            leave-active-class="transition-all duration-1000 ease-in delay-500"
            enter-class="opacity-0 scale-70"
            enter-to-class="scale-100 opacity-100"
            leave-class="scale-100 opacity-100"
            leave-to-class="opacity-0 scale-70"
            mode="out-in"
        >
            <component :is="Component" />
        </transition>
    </router-view> -->

    <div>
      <sidebar />
      <div class="relative md:ml-64 bg-blueGray-100">
        <admin-navbar />
        <header-stats />
        <div class="w-full px-4 mx-auto -m-24 md:px-10">
          <router-view />
          <footer-admin />
        </div>
      </div>
    </div>
</template>

<script>
    import SessionAlert from '../components/alerts/SessionAlert.vue';
    import AdminNavbar from "../components/Navbars/AdminNavbar.vue";
    import Sidebar from "../components/Sidebar/Sidebar.vue";
    import HeaderStats from "../components/Headers/HeaderStats.vue";
    import FooterAdmin from "../components/Footers/FooterAdmin.vue";
    export default {
        components: {
            SessionAlert,
            AdminNavbar,
            Sidebar,
            HeaderStats,
            FooterAdmin,
        },
        methods : {
        },
        mounted() {
            
        },
        data() {
            return {
                // transitionName: 'slide-right',
            };
        },
        watch: {
            // '$route' (to, from) {
            //     console.log(to);
            //     this.transitionName = 'slide-left';
            //     // 'fade'
            // }
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
