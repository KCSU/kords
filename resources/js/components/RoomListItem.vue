<template>
  <div class="bg-white shadow-sm rounded-xl p-6 flex cursor-pointer hover:shadow-md transition-shadow duration-150"
  @click="$emit('click')">
    <img
      :src="room.image"
      class="object-cover h-32 w-44 rounded-md object-center"
    />
    <div class="flex flex-col ml-5 w-full">
      <div class="font-bold text-xl flex items-center justify-between">
        <div>
          <span class="mr-2" :class="{'text-red-900 line-through italic': !room.available }">{{ room.number }}</span>
          <span
            v-for="i in room.band"
            :key="i"
            class="text-purple-600 font-medium font-mono pr-0.25"
            >£</span
          >
        </div>
      </div>
      <span class="text-sm text-gray-500 font-medium">
        <i class="lni lni-map-marker text-md"></i>
        {{ room.location }}, Floor {{ room.floor }}
      </span>
      <div class="flex-grow"></div>
      <div class="flex flex-wrap justify-between 2xl:flex-nowrap">
        <room-feature name="Rent" icon="credit-cards" nowrap>{{ room.rent }}</room-feature>
        <room-feature name="Contract" icon="calendar" nowrap>{{ room.long_contract ? 'Long / Short' : 'Short'}}</room-feature>
        <room-feature name="Perks" icon="diamond-alt">{{ perks }}</room-feature>
      </div>
    </div>
  </div>
</template>

<script>
import RoomFeature from './RoomFeature.vue'

function prettify(perk) {
  return perk.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
}

export default {
  props: {
    room: Object,
  },
  computed: {
    perks() {
      const possiblePerks = ["set", "ensuite", "piano", "double_bed", "basin", "smoking"];
      return possiblePerks.filter(perk => this.room[perk]).map(prettify).join(", ");
    }
  },
  components: {RoomFeature}
};
</script>

<style scoped>

.line-through {
  text-decoration-thickness: 2px;
}

</style>