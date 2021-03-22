<template>
  <div
    @click="$emit('input', !value)"
    class="cursor-pointer relative flex border-gray-300 border w-44 rounded-xl items-center justify-around text-sm font-medium"
  >
    <div
      class="absolute w-1/2 bg-white h-full z-0 rounded-xl shadow-sm transition-left duration-150"
      :class="`left-${value ? '1/2' : '0'}`"
    ></div>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="`text-gray-${value ? 500 : 800}`">{{ first }}</span>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="`text-gray-${value ? 800 : 500}`">{{ second }}</span>
  </div>
</template>

<script>
export default {
  props: {
    value: Boolean,
    first: String,
    second: String
  },
};
</script>