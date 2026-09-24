<template>
  <div class="relative">
    <div class="relative flex items-center">
      <i
        class="lni lni-search-alt text-2xl absolute left-6 pointer-events-none text-gray-400"
      ></i>
      <input
        :value="modelValue"
        @input="handleInput"
        class="shadow-xs font-medium bg-white pr-6 pl-16 py-7 grow rounded-xl text-md outline-hidden"
        :placeholder="placeholder"
      />
      <i
        class="lni lni-chevron-down text-lg p-2 absolute text-gray-500 transform cursor-pointer right-6 transition-transform ease-in-out duration-300"
        :class="{'-rotate-180': toggled}"
        @click="$emit('toggle')"
      ></i>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: String,
    placeholder: String,
    toggled: {
      type: Boolean,
      default: false
    }
  },
  emits: ['update:modelValue', 'toggle'],
  methods: {
    handleInput(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>