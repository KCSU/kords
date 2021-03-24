<template>
  <div class="h-screen bg-gray-100 flex overflow-hidden">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      v-model="selected"
    ></sidebar-nav>
    <div class="flex items-center flex-col w-full p-10 overflow-y-scroll h-full">
      <div class="flex flex-col items-stretch xl:w-8/12 w-full relative">
        <search-bar
          :toggled="showFilters"
          @toggle="showFilters = !showFilters"
          v-model="searchString"
          placeholder="Search for a room number, location, etc."
        ></search-bar>
        <transition name="fade">
          <search-options
            v-model="searchFilters"
            v-show="showFilters"
          ></search-options>
        </transition>
        <div class="flex my-10 justify-between">
          <span class="text-3xl font-semibold">Rooms</span>
          <toggle v-model="isGrid" first="List" second="Grid"></toggle>
        </div>
        <transition name="fade-down" mode="out-in">
        <div key="grid" class="grid grid-cols-fill-56 gap-6 mb-6" v-if="isGrid">
          <room-grid-item
            v-for="room in roomResults"
            :key="room.id"
            :room="room"
            @click="focusDetail(room)">
          </room-grid-item>
        </div>
        <div key="list" class="flex flex-col w-full" v-if="!isGrid">
          <room-list-item
            class="mb-6"
            v-for="room in roomResults"
            :key="room.id"
            :room="room"
            @click="focusDetail(room)"
          ></room-list-item>
        </div>
        </transition>
      </div>
    </div>
    <detail-panel
      v-model="detailFocused"
      ref="detail"
      @next="nextRoom"
      @back="prevRoom"
    >
      <room-details :room="selectedRoom" @comment="addComment($event)"></room-details>
    </detail-panel>
  </div>
</template>

<script>
import Fuse from 'fuse.js'

import SidebarNav from "~/components/SidebarNav";
import SearchBar from "~/components/SearchBar";
import Toggle from "~/components/Toggle";
import RoomListItem from "~/components/RoomListItem";
import DetailPanel from "~/components/DetailPanel";
import RoomDetails from "~/components/RoomDetails";
import SearchOptions from "~/components/SearchOptions";
import RoomGridItem from "~/components/RoomGridItem"

const options = {
  keys: [
    'number', 'location'
  ]
}

export default {
  methods: {
    focusDetail(room) {
      this.detailFocused = true;
      this.selectedRoom = room;
      this.$refs.detail.$el.focus();
    },
    nextRoom() {
      let roomIdx = this.roomResults.findIndex((x) => x.id === this.selectedRoom.id);
      if (roomIdx === -1) {
        return;
      }
      this.selectedRoom = this.roomResults[
        Math.min(roomIdx + 1, this.roomResults.length - 1)
      ];
    },
    prevRoom() {
      let roomIdx = this.roomResults.findIndex((x) => x.id === this.selectedRoom.id);
      if (roomIdx === -1) {
        return;
      }
      this.selectedRoom = this.roomResults[Math.max(roomIdx - 1, 0)];
    },
    addComment(comment) {
      let room = this.rooms.find(r => r.id === comment.room_id);
      console.log(room);
      if (room) {
        room.comments.unshift(comment);
      }
    }
  },
  computed: {
    fuse() {
      return new Fuse(this.rooms, options);
    },
    roomResults() {
      let results;
      if (this.searchString === '') {
        results = this.rooms;
      } else {
        results = this.fuse.search(this.searchString).map(r => r.item);
      }
      results = results.filter(room => 
        this.searchFilters.locations.includes(room.location) &&
        this.searchFilters.bands.includes(room.band) &&
        this.searchFilters.perks.every(p => room.perks.some(pk => pk.name === p)) &&
        (room.long_contract || !this.searchFilters.long_contract) &&
        (room.available || !this.searchFilters.available) &&
        (room.ballot_id === this.selected || this.selected === 0)
      );
      return results;
    }
  },
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
      this.searchFilters.locations = data.map(l => l.name);
    });
    window.api.get("/ballots").then(({data}) => {
      this.navItems = [
        {
          name: "All Rooms",
          icon: "home",
          id: 0
        },
        ...data.primary
      ];
      this.navSubItems = data.sub;
    });
  },
  data() {
    return {
      isGrid: true,
      detailFocused: false,
      selected: 0,
      selectedRoom: {},
      searchString: "",
      rooms: [],
      showFilters: false,
      searchFilters: {
        long_contract: false,
        available: false,
        bands: [1, 2, 3, 4, 5, 6],
        perks: [],
        locations: []
      },
      navItems: [],
      navSubItems: []
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
    RoomGridItem
  },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .15s, transform .15s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(-20px);
}

.fade-down-enter-active, .fade-down-leave-active {
  transition: opacity .15s, transform .15s;
}
.fade-down-enter, .fade-down-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(20px);
}
</style>