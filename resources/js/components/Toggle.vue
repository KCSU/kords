<template>
  <div
    @click="$emit('input', !value)"
    class="cursor-pointer relative flex border-gray-300 border w-44 rounded-xl items-center justify-around text-sm font-medium"
  >
    <div
      class="absolute w-1/2 bg-white h-full z-0 rounded-xl shadow-sm transition-left duration-150"
      :class="value ? 'left-1/2' : 'left-0'"
    ></div>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="value ? 'text-gray-500' : 'text-gray-800'">{{ first }}</span>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="value ? 'text-gray-800' : 'text-gray-500'">{{ second }}</span>
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