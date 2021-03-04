<template>
  <div class="relative flex items-center">
    <i
      class="lni lni-search-alt text-2xl absolute left-6 pointer-events-none text-gray-400"
    ></i>
    <input
      :value="value"
      @input="handleInput"
      class="shadow-sm font-medium bg-white pr-6 pl-16 py-7 w-full rounded-xl text-md outline-none"
      :placeholder="placeholder"
    />
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    placeholder: String
  },
  methods: {
    handleInput(event) {
      this.$emit("input", event.target.value);
    },
  },
};
</script>