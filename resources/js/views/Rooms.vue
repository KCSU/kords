<template>
  <div class="h-screen bg-gray-100 flex overflow-hidden">
    <sidebar-nav
      :items="navItems"
      :subItems="navSubItems"
      :loading="ballotsLoading"
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
        <div key="loading" v-if="roomsLoading">Loading...</div>
        <div key="grid" class="grid grid-cols-fill-56 gap-6 mb-6" v-else-if="isGrid">
          <room-grid-item
            v-for="room in roomResults"
            :key="room.id"
            :room="room"
            @click="focusDetail(room)">
          </room-grid-item>
        </div>
        <div key="list" class="flex flex-col w-full" v-else>
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
      :value="detailFocused"
      @input="detailFocused = $event || modalOpen"
      ref="detail"
      @next="nextRoom"
      @back="prevRoom"
    >
      <room-details :room="selectedRoom" @comment="addComment($event)"></room-details>
    </detail-panel>
    <modal :showing="modalOpen" @close="modalClose()" class="bg-black bg-opacity-50"
    @keydown.right.native="nextImg()" @keydown.left.native="prevImg()"
    tabindex="0"
    ref="modal">
      <div class="flex justify-center items-stretch">
        <div @click="prevImg()" class="cursor-pointer pr-4 flex justify-end items-center flex-grow">
          <i class="lni lni-chevron-left text-3xl text-gray-700"></i>
        </div>
        <img :src="modalImg" class="modal-img"/>
        <div @click="nextImg()" class="cursor-pointer pl-4 flex justify-start items-center flex-grow">
          <i class="lni lni-chevron-right text-3xl text-gray-700"></i>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Fuse from 'fuse.js'

import EventBus from '~/services/EventBus';
import SidebarNav from "~/components/SidebarNav";
import SearchBar from "~/components/SearchBar";
import Toggle from "~/components/Toggle";
import RoomListItem from "~/components/RoomListItem";
import DetailPanel from "~/components/DetailPanel";
import RoomDetails from "~/components/RoomDetails";
import SearchOptions from "~/components/SearchOptions";
import RoomGridItem from "~/components/RoomGridItem";
import Modal from '~/components/Modal';

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
      this.$nextTick(() => {
        this.$refs.detail.$el.focus();
      });
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
    nextImg() {
      EventBus.$emit('nextImg', this.modalImg);
    },
    prevImg() {
      EventBus.$emit('prevImg', this.modalImg);
    },
    modalClose() {
      this.modalOpen = false;
      this.$nextTick(() => {
        this.$refs.detail.$el.focus();
      });
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
      this.roomsLoading = false;
      this.rooms = data.map((room) => ({
        ...room,
        image: room.images[0] || "//via.placeholder.com/300x200?text=%3F"
      }));
    });
    window.api.get("/locations").then(({data}) => {
      this.locationsLoading = false;
      this.searchFilters.locations = data.map(l => l.name);
    });
    window.api.get("/ballots").then(({data}) => {
      this.ballotsLoading = false;
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
    EventBus.$on('openModal', src => {
      this.modalOpen = true;
      this.modalImg = src;
      this.$nextTick(() => {
        this.$refs.modal.$el?.focus();
      })
    })
  },
  data() {
    return {
      isGrid: localStorage.getItem('rooms.isGrid') !== 'false',
      modalOpen: false,
      modalImg: "",
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
      navSubItems: [],
      roomsLoading: true,
      locationsLoading: true,
      ballotsLoading: true
    };
  },
  watch: {
    isGrid(val) {
      localStorage.setItem('rooms.isGrid', val.toString());
    }
  },
  components: {
    SidebarNav,
    SearchBar,
    Toggle,
    RoomListItem,
    DetailPanel,
    RoomDetails,
    SearchOptions,
    RoomGridItem,
    Modal
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

.modal-img {
  max-width: 600px;
}
</style>