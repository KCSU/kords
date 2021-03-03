<template>
  <div class="h-screen bg-gray-100">
    <sidebar-nav :items="navItems" :subItems="navSubItems" v-model="selected"></sidebar-nav>
  </div>
</template>

<script>
import SidebarNav from './SidebarNav.vue'

export default {
  data() {
    return {
      selected: "all",
      navItems: [
        {
          title: "All Rooms",
          value: "all",
          icon: "home"
        },
        {
          title: "Undergraduate",
          value: "undergrad",
          icon: "library"
        },
        {
          title: "Graduate",
          value: "graduate",
          icon: "graduation"
        }
      ],
      navSubItems: [
        {
          title: "1st Year",
          value: "1styear"
        }
      ]
    };
  },
  components: { SidebarNav }
};
</script>