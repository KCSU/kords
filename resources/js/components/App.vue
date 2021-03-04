<template>
  <div class="h-screen bg-gray-100 flex">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      v-model="selected"
    ></sidebar-nav>
    <div class="flex items-center flex-col w-full m-10">
      <div class="flex flex-col items-stretch xl:w-8/12 w-full">
        <search-bar v-model="searchString" placeholder="Search for a room number, location, etc."></search-bar>
        <div class="flex my-10 justify-between">
          <span class="text-3xl font-medium">Rooms</span>
          <toggle v-model="isGrid" first="List" second="Grid"></toggle>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SidebarNav from "./SidebarNav.vue";
import SearchBar from "./SearchBar.vue";
import Toggle from "./Toggle.vue";

export default {
  data() {
    return {
      isGrid: false,
      selected: "all",
      searchString: "",
      navItems: [
        {
          title: "All Rooms",
          value: "all",
          icon: "home",
        },
        {
          title: "Undergraduate",
          value: "undergrad",
          icon: "library",
        },
        {
          title: "Graduate",
          value: "graduate",
          icon: "graduation",
        },
      ],
      navSubItems: [
        {
          title: "1st Year Undergrad",
          value: "1styear",
        },
        {
          title: "Organ Scholar",
          value: "organ"
        },
        {
          title: "1st Year Graduate",
          value: "1styeargrad"
        },
        {
          title: "Letrice",
          value: "letrice"
        },
        {
          title: "Graduate Warden",
          value: "gradwarden"
        }
      ],
    };
  },
  components: { SidebarNav, SearchBar, Toggle },
};
</script>