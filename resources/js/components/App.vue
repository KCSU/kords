<template>
  <div class="h-screen bg-gray-100 flex overflow-hidden">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      v-model="selected"
    ></sidebar-nav>
    <div class="flex items-center flex-col w-full p-10 overflow-y-auto h-full">
      <div class="flex flex-col items-stretch xl:w-8/12 w-full relative">
        <search-bar
          @toggle="showFilters = !showFilters"
          v-model="searchString"
          placeholder="Search for a room number, location, etc."
        ></search-bar>
        <search-options
          v-model="searchFilters"
          v-show="showFilters"
        ></search-options>
        <div class="flex my-10 justify-between">
          <span class="text-3xl font-semibold">Rooms</span>
          <toggle v-model="isGrid" first="List" second="Grid"></toggle>
        </div>
        <div class="flex flex-col w-full">
          <room-list-item
            class="mb-6"
            v-for="room in rooms"
            :key="room.id"
            :room="room"
            @click="focusDetail(room)"
          ></room-list-item>
        </div>
      </div>
    </div>
    <detail-panel
      v-model="detailFocused"
      ref="detail"
      @next="nextRoom"
      @back="prevRoom"
    >
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
import RoomDetails from "./RoomDetails.vue";
import SearchOptions from "./SearchOptions.vue";

export default {
  methods: {
    focusDetail(room) {
      this.detailFocused = true;
      this.selectedRoom = room;
      this.$refs.detail.$el.focus();
    },
    nextRoom() {
      let roomIdx = this.rooms.findIndex((x) => x.id === this.selectedRoom.id);
      this.selectedRoom = this.rooms[
        Math.min(roomIdx + 1, this.rooms.length - 1)
      ];
    },
    prevRoom() {
      let roomIdx = this.rooms.findIndex((x) => x.id === this.selectedRoom.id);
      this.selectedRoom = this.rooms[Math.max(roomIdx - 1, 0)];
    },
  },
  computed: {},
  created() {
    window.api.get("/rooms").then(({ data }) => {
      this.rooms = data.map((room) => ({
        ...room,
        image: "https://picsum.photos/200",
        images: [
          "https://picsum.photos/200",
          "https://picsum.photos/200?1",
          "https://picsum.photos/200?2",
        ],
      }));
    });
    window.api.get("/locations").then(({data}) => {
      let locs = {};
      data.forEach(l => { locs[l.name] = true; });
      this.searchFilters.locations = locs;
    });
  },
  data() {
    return {
      isGrid: false,
      detailFocused: false,
      selected: "all",
      selectedRoom: {},
      searchString: "",
      rooms: [],
      showFilters: false,
      searchFilters: {
        bands: [1, 2, 3, 4, 5, 6],
        perks: {},
        locations: {}
      },
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
    SearchOptions,
  },
};
</script>
