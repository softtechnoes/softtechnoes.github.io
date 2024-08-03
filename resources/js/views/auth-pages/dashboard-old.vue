<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <div class="w-64 px-4 py-6 text-white bg-gray-800">
        <!-- Your Sidebar Content Goes Here -->
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <!-- Sidebar Navigation -->
        <ul class="mt-6">
          <li class="mb-2">
            <router-link to="/dashboard" class="text-gray-300 hover:text-white">Home</router-link>
          </li>
          <li class="mb-2">
            <router-link to="/dashboard/analytics" class="text-gray-300 hover:text-white">Analytics</router-link>
          </li>
          <li class="mb-2">
            <button @click="initiateLogout" class="text-gray-300 hover:text-white">Logout</button>
          </li>
          <!-- Add more sidebar links as needed -->
        </ul>
      </div>
  
      <!-- Main Content -->
      <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Header -->
        <header class="px-6 py-4 bg-white border-b border-gray-200">
          <!-- Your Header Content Goes Here -->
          <h2 class="text-2xl font-semibold">Welcome to the Dashboard</h2>
        </header>
  
        <!-- Page Content -->
        <div class="flex-1 overflow-x-hidden overflow-y-scroll bg-gray-200">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { mapActions,mapState } from 'vuex';
  export default {
    // Add any component logic or methods here
    methods: {
    ...mapActions('currentUser',['logout']),
    initiateLogout() {
      this.logout().then(res => {
        console.log(res)
      }).catch(err => {
        console.log(err)
      })
    }
  }
  };
  </script>
  