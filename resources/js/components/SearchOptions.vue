<template>
  <div
    class="absolute top-20 mt-2 z-20 shadow-xl rounded-lg p-5 w-full bg-white border border-gray-300 flex flex-wrap"
  >
    <div class="mr-10">
      <div class="text-xl font-medium">Rent Bands</div>
      <multi-select :value="value.bands" @input="update('bands', $event)" :options="bandOpts"></multi-select>
    </div>
    <div>
      <div class="text-xl font-medium">Perks</div>
      <div class="flex">
        <checkbox-chip icon="home" :value="value.home" @input="update('home', $event)">Home</checkbox-chip>
      </div>
    </div>
  </div>
</template>

<script>
import CheckboxChip from './CheckboxChip.vue';
import MultiSelect from './MultiSelect.vue';
export default {
  components: { MultiSelect, CheckboxChip },
  props: {
    value: Object,
  },
  computed: {
    bandOpts() {
      let options = [];
      // TODO: replace with API query
      for (let i = 1; i <= 6; i++) {
        options.push({
          name: i.toString(),
          value: i
        });
      }
      return options;
    }
  },
  methods: {
    update(key, value) {
      this.$emit("input", { ...this.value, [key]: value });
    },
  },
};
</script>