<template>
  <div class="relative">
    <div class="relative flex items-center">
      <i
        class="lni lni-search-alt text-2xl absolute left-6 pointer-events-none text-gray-400"
      ></i>
      <input
        :value="value"
        @input="handleInput"
        class="shadow-sm font-medium bg-white pr-6 pl-16 py-7 flex-grow rounded-xl text-md outline-none"
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
    value: String,
    placeholder: String,
    toggled: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    handleInput(event) {
      this.$emit("input", event.target.value);
    },
  },
};
</script>