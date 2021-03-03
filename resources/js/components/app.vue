<template>
  <div class="h-screen bg-gray-100">
    <Nav :items="navItems" v-model="selected"/>  
  </div>
</template>

<script>
import Nav from './nav.vue'

export default {
  data() {
    return {
      selected: "",
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
      ]
    };
  },
  components: { Nav }
};
</script>