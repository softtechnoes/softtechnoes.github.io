<template>
    <div class="flex flex-wrap">
      <div class="w-full px-4 lg:w-8/12">
        <CardSettings />
      </div>
      <div class="w-full px-4 lg:w-4/12">
        <CardProfile />
      </div>
    </div>
  </template>
  <script>
  import CardSettings from "../../components/Cards/CardSettings.vue";
  import CardProfile from "../../components/Cards/CardProfile.vue";
  
  export default {
    components: {
      CardSettings,
      CardProfile,
    },
    created(){
        document.title = this.$Lang_get('auth.settings')+" | "+process.env.MIX_APP_NAME;
    },
  };
  </script>
  