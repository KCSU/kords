<template>
  <div
    class="bg-white overflow-hidden shadow-sm rounded-xl flex flex-col cursor-pointer hover:shadow-md transition-shadow duration-150"
    @click="$emit('click')"
  >
    <img :src="room.image" class="object-cover w-full h-32 object-center" />
    <div class="flex px-6 mt-2 text-xl font-bold">
      <span
        class="mr-2"
        :class="{ 'text-red-900 line-through italic': !room.available }"
        >{{ room.number }}</span
      >
      <span
        v-for="i in room.band"
        :key="i"
        class="text-purple-600 font-medium font-mono pr-0.25"
        >£</span
      >
    </div>
    <span class="text-xs text-gray-500 font-medium px-6 mb-4">
      <i class="lni lni-map-marker text-md"></i>
      {{ room.location }}, Floor {{ room.floor }}
    </span>
  </div>
</template>

<script>
export default {
  props: {
    room: Object,
  },
};
</script>