<template>
  <div class="bg-gray-200 rounded-md flex overflow-hidden items-center">
    <div
      v-for="(option, i) in options"
      :key="`option-${i}`"
      @click="toggle(option.value)"
      class="px-2 py-1 transition-colors duration-150 cursor-pointer"
      :class="{ 'bg-purple-600 text-white': modelValue.includes(option.value) }"
    >
      {{ option.name }}
    </div>
    <div class="px-2 py-1 border-l-2 border-transparent transition-colors duration-150 cursor-pointer" @click="toggleAll()"
    :class="{'bg-purple-600 border-purple-500 text-white': modelValue.length == options.length}">
      <i class="lni lni-checkmark"></i>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    options: Array,
    modelValue: Array,
  },
  emits: ['update:modelValue'],
  methods: {
    toggle(v) {
      if (!this.modelValue.includes(v)) {
        this.$emit("update:modelValue", [...this.modelValue, v]);
      } else {
        this.$emit(
          "update:modelValue",
          this.modelValue.filter((x) => x != v)
        );
      }
    },
    toggleAll() {
        if (this.modelValue.length === this.options.length) {
            this.$emit('update:modelValue', []);
        } else {
            this.$emit('update:modelValue', this.options.map(x => x.value));
        }
    }
  },
};
</script>