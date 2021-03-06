<template>
  <div class="h-screen bg-gray-100 flex">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      v-model="selected"
    ></sidebar-nav>
    <div class="flex items-center flex-col w-full m-10">
      <div class="flex flex-col items-stretch xl:w-8/12 w-full">
        <search-bar
          v-model="searchString"
          placeholder="Search for a room number, location, etc."
        ></search-bar>
        <div class="flex my-10 justify-between">
          <span class="text-3xl font-medium">Rooms</span>
          <toggle v-model="isGrid" first="List" second="Grid"></toggle>
        </div>
        <div class="flex flex-col w-full">
          <room-list-item v-for="room in rooms" :key="room.number" :room="room" @click="focusDetail(room)"></room-list-item>
        </div>
      </div>
    </div>
    <detail-panel v-model="detailFocused" :title="selectedRoom.number" ref="detail"></detail-panel>
  </div>
</template>

<script>
import SidebarNav from "./SidebarNav.vue";
import SearchBar from "./SearchBar.vue";
import Toggle from "./Toggle.vue";
import RoomListItem from "./RoomListItem.vue";
import DetailPanel from './DetailPanel.vue'

export default {
  methods: {
    focusDetail(room) {
      console.log("Something")
      this.detailFocused = true;
      this.selectedRoom = room;
      this.$refs.detail.$el.focus();
    }
  },
  data() {
    return {
      isGrid: false,
      detailFocused: false,
      selected: "all",
      selectedRoom: {
        number: ''
      },
      searchString: "",
      rooms: [
        {
          number: "V8",
          location: "Bodley's Court",
          image: "https://via.placeholder.com/200",
          band: 6,
          floor: 2,
          rent: "£1687.12 / £1934.33",
          long_contract: true,
          piano: true,
          set: true,
          double_bed: true,
          ensuite: false,
          basin: true,
        },
      ],
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
          value: "organ",
        },
        {
          title: "1st Year Graduate",
          value: "1styeargrad",
        },
        {
          title: "Letrice",
          value: "letrice",
        },
        {
          title: "Graduate Warden",
          value: "gradwarden",
        },
      ],
    };
  },
  components: { SidebarNav, SearchBar, Toggle, RoomListItem, DetailPanel },
};
</script>