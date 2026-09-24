<template>
  <div
    @click="$emit('update:modelValue', !modelValue)"
    class="cursor-pointer relative flex border-gray-300 border w-44 rounded-xl items-center justify-around text-sm font-medium"
  >
    <div
      class="absolute w-1/2 bg-white h-full z-0 rounded-xl shadow-xs transition-left duration-150"
      :class="modelValue ? 'left-1/2' : 'left-0'"
    ></div>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="modelValue ? 'text-gray-500' : 'text-gray-800'">{{ first }}</span>
    <span class="p-2 z-10 transition-colors duration-150 flex-1 text-center" :class="modelValue ? 'text-gray-800' : 'text-gray-500'">{{ second }}</span>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: Boolean,
    first: String,
    second: String
  },
  emits: ['update:modelValue'],
};
</script>