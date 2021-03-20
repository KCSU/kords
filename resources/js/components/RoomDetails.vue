<template>
  <div>
    <div class="flex items-center">
      <h1 class="text-3xl font-semibold">{{ room.number }}</h1>
      <toggled-chip
        class="ml-4"
        :toggled="room.available"
        active="Available"
        inactive="Unavailable"
      ></toggled-chip>
    </div>
    <div class="text-gray-400 text-sm font-medium my-2 flex items-center">
      <i class="lni lni-map-marker mr-2"></i>
      {{ room.location }}, Floor {{ room.floor }}
    </div>
    <hr class="mt-8 mb-4" />
    <h3 class="text-xl font-medium mb-2">Contract</h3>
    <div>
      Available on <b>{{ room.long_contract ? 'Long or Short' : 'Short' }}</b> contract. <br/>
      Band {{ room.band }}: <b>{{ room.rent }}</b>
    </div>
    <h3 class="text-xl font-medium mt-4">Photos</h3>
    <div class="flex flex-wrap -mx-3">
      <img
        v-for="(img, i) in room.images"
        :key="i"
        :src="img"
        class="rounded-xl shadow-sm transition-shadow duration-150 hover:shadow-md m-3 flex-1 max-h-36 object-cover cursor-pointer"
      />
    </div>
    <h3 class="text-xl font-medium mt-4">Key Features</h3>
    <div class="flex flex-wrap rounded-md shadow-inner bg-gray-100 mt-3 justify-evenly pb-3 mb-6">
      <div v-for="(perk, i) in perks" :key="`perk-${i}`"
      class="rounded-xl shadow mt-3 flex-initial inline-flex flex-col align-middle justify-around w-24 h-24 bg-white text-center p-2 font-medium text-sm">
        <i class="material-icons-round text-3xl text-purple-900">{{ perk.icon }}</i>
        <span>{{ perk.name }}</span>
      </div>
    </div>
    <!-- TODO: Comments section -->
  </div>
</template>

<script>
import ToggledChip from "./ToggledChip.vue";

function prettify(perk) {
  const perkIcons = {
    set: 'meeting_room',
    ensuite: 'shower',
    piano: 'piano',
    double_bed: 'king_bed',
    basin: 'countertops',
    fridge: 'kitchen',
    smoking: 'smoking_rooms'
  };
  return {
    name: perk.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" "),
    icon: perkIcons[perk]
  };
}

export default {
  props: {
    room: Object,
  },
  computed: {
    perks() {
      const possiblePerks = ["set", "ensuite", "piano", "double_bed", "basin", "smoking"];
      return possiblePerks.filter(perk => this.room[perk]).map(prettify);
    }
  },
  components: { ToggledChip },
};
</script>
