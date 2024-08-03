<template>
  <div>
    <a
      class="block text-blueGray-500"
      href="#pablo"
      ref="btnDropdownRef"
      v-on:click="toggleDropdown($event)"
    >
      <div class="flex items-center">
        <span
          class="inline-flex items-center justify-center w-12 h-12 text-sm text-white rounded-full bg-blueGray-200"
        >
          <img
            alt="..."
            class="w-full align-middle border-none rounded-full shadow-lg"
            :src="image"
          />
        </span>
      </div>
    </a>
    <div
      ref="popoverDropdownRef"
      class="z-50 float-left py-2 text-base text-left list-none bg-white rounded shadow-lg min-w-48"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow,
      }"
    >
      <span
          class="block w-full px-4 py-2 text-sm font-normal font-bold bg-transparent whitespace-nowrap text-blueGray-700"
        >
        {{auth_user.name}}
    </span>
      <a
        href="javascript:void(0);"
        class="block w-full px-4 py-2 text-sm font-normal bg-transparent whitespace-nowrap text-blueGray-700"
      >
        Action
      </a>
      <a
        href="javascript:void(0);"
        class="block w-full px-4 py-2 text-sm font-normal bg-transparent whitespace-nowrap text-blueGray-700"
      >
        Another action
      </a>
      <a
        href="javascript:void(0);"
        class="block w-full px-4 py-2 text-sm font-normal bg-transparent whitespace-nowrap text-blueGray-700"
      >
        Something else here
      </a>
      <div class="h-0 my-2 border border-solid border-blueGray-100" />
      <span @click="initiateLogout"
        class="block w-full px-4 py-2 text-sm font-normal bg-transparent cursor-pointer whitespace-nowrap text-blueGray-700"
      >
        Logout
    </span>
    </div>
  </div>
</template>

<script>
import { createPopper } from "@popperjs/core";

import { mapActions, mapState } from 'vuex';

export default {
  data() {
    return {
      dropdownPopoverShow: false,
      image: "/assets/img/team-1-800x800.jpg",
    };
  },
  computed: {
    ...mapState("currentUser", ["auth_user"]),
  },
  methods: {
    ...mapActions('currentUser',['logout']),
    toggleDropdown: function (event) {
      event.preventDefault();
      if (this.dropdownPopoverShow) {
        this.dropdownPopoverShow = false;
      } else {
        this.dropdownPopoverShow = true;
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start",
        });
      }
    },
    
    initiateLogout() {
      this.logout().then(res => {
        if(res) {
          this.$router.push({ path: '/auth/login' })
        }
        
      }).catch(err => {
        console.log(err)
      })
    }
  },
};
</script>
