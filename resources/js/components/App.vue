<template>
  <div class="h-screen bg-gray-100 flex overflow-hidden">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      v-model="selected"
    ></sidebar-nav>
    <div class="flex items-center flex-col w-full p-10 overflow-y-auto h-full">
      <div class="flex flex-col items-stretch xl:w-8/12 w-full">
        <search-bar
          v-model="searchString"
          placeholder="Search for a room number, location, etc."
        ></search-bar>
        <div class="flex my-10 justify-between">
          <span class="text-3xl font-semibold">Rooms</span>
          <toggle v-model="isGrid" first="List" second="Grid"></toggle>
        </div>
        <div class="flex flex-col w-full">
          <room-list-item
            class="mb-6"
            v-for="room in rooms"
            :key="room.number"
            :room="room"
            @click="focusDetail(room)"
          ></room-list-item>
        </div>
      </div>
    </div>
    <detail-panel v-model="detailFocused" ref="detail">
      <room-details :room="selectedRoom"></room-details>
    </detail-panel>
  </div>
</template>

<script>
import SidebarNav from "./SidebarNav.vue";
import SearchBar from "./SearchBar.vue";
import Toggle from "./Toggle.vue";
import RoomListItem from "./RoomListItem.vue";
import DetailPanel from "./DetailPanel.vue";
import RoomDetails from './RoomDetails.vue';

export default {
  methods: {
    focusDetail(room) {
      console.log("Something");
      this.detailFocused = true;
      this.selectedRoom = room;
      this.$refs.detail.$el.focus();
    },
  },
  data() {
    let room = {
      number: "V8",
      location: "Bodley's Court",
      image: "https://picsum.photos/200",
      images: [
        "https://picsum.photos/200",
        "https://picsum.photos/200?1",
        "https://picsum.photos/200?2",
      ],
      band: 6,
      floor: 2,
      rent: "£1687.12 / £1934.33",
      long_contract: true,
      piano: true,
      set: true,
      double_bed: true,
      ensuite: false,
      basin: true,
      available: true,
    };
    return {
      isGrid: false,
      detailFocused: true,
      selected: "all",
      selectedRoom: room,
      searchString: "",
      rooms: [room, room, room],
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
  components: {
    SidebarNav,
    SearchBar,
    Toggle,
    RoomListItem,
    DetailPanel,
    RoomDetails,
  },
};
</script>
