<template>
    <!-- <div class="w-full ">
      Dashboard data
      <header-stats /> -->
      <!-- <sidebar />
      <div class="relative md:ml-64 bg-blueGray-100">
        <admin-navbar />
        <header-stats />
        <div class="w-full px-4 mx-auto -m-24 md:px-10"> -->
          <!-- <router-view /> -->
          <!-- <footer-admin />
        </div>
      </div> -->
    <!-- </div> -->


    <div>
         <!-- Card stats -->
    <div class="flex flex-wrap">
          <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
            <card-stats
              statSubtitle="TRAFFIC"
              statTitle="350,897"
              statArrow="up"
              statPercent="3.48"
              statPercentColor="text-emerald-500"
              statDescripiron="Since last month"
              statIconName="far fa-chart-bar"
              statIconColor="bg-red-500"
            />
          </div>
          <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
            <card-stats
              statSubtitle="NEW USERS"
              statTitle="2,356"
              statArrow="down"
              statPercent="3.48"
              statPercentColor="text-red-500"
              statDescripiron="Since last week"
              statIconName="fas fa-chart-pie"
              statIconColor="bg-orange-500"
            />
          </div>
          <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
            <card-stats
              statSubtitle="SALES"
              statTitle="924"
              statArrow="down"
              statPercent="1.10"
              statPercentColor="text-orange-500"
              statDescripiron="Since yesterday"
              statIconName="fas fa-users"
              statIconColor="bg-pink-500"
            />
          </div>
          <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
            <card-stats
              statSubtitle="PERFORMANCE"
              statTitle="49,65%"
              statArrow="up"
              statPercent="12"
              statPercentColor="text-emerald-500"
              statDescripiron="Since last month"
              statIconName="fas fa-percent"
              statIconColor="bg-emerald-500"
            />
          </div>
        </div>
    <div class="flex flex-wrap mt-5">
      
      <div class="w-full px-4 mb-12 xl:w-8/12 xl:mb-0">
        <card-line-chart />
      </div>
      <div class="w-full px-4 xl:w-4/12">
        <card-bar-chart />
      </div>
    </div>
    <div class="flex flex-wrap mt-4">
      <div class="w-full px-4 mb-12 xl:w-8/12 xl:mb-0">
        <card-page-visits />
      </div>
      <div class="w-full px-4 xl:w-4/12">
        <card-social-traffic />
      </div>
    </div>
 
  </div>
  </template>
  <script>
  import AdminNavbar from "../../components/Navbars/AdminNavbar.vue";
  import Sidebar from "../../components/Sidebar/Sidebar.vue";
  import HeaderStats from "../../components/Headers/HeaderStats.vue";
  import FooterAdmin from "../../components/Footers/FooterAdmin.vue";

  import CardLineChart from "../../components/Cards/CardLineChart.vue";
  import CardBarChart from "../../components/Cards/CardBarChart.vue";
  import CardPageVisits from "../../components/Cards/CardPageVisits.vue";
  import CardSocialTraffic from "../../components/Cards/CardSocialTraffic.vue";
  import CardStats from "../../components/Cards/CardStats.vue";
  
  export default {
    name: "admin-layout",
    components: {
      AdminNavbar,
      Sidebar,
      HeaderStats,
      FooterAdmin,
      CardLineChart,
      CardBarChart,
      CardPageVisits,
      CardSocialTraffic,
      CardStats
    },
    created(){
        document.title = this.$Lang_get('auth.dashboard')+" | "+process.env.MIX_APP_NAME;
    },
  };
  </script>
  