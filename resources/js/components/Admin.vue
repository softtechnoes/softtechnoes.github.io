<template>
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
import AdminNavbar from "../Navbars/AdminNavbar.vue";
import Sidebar from "../Sidebar/Sidebar.vue";
import HeaderStats from "../Headers/HeaderStats.vue";
import FooterAdmin from "../Footers/FooterAdmin.vue";
export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    HeaderStats,
    FooterAdmin,
  },
};
</script>
