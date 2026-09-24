<template>
  <div
    class="absolute top-20 mt-2 z-20 shadow-xl rounded-lg p-5 w-full bg-white border border-gray-300 flex flex-wrap"
  >
    <div class="mr-10 mb-3">
      <div class="text-xl font-medium">Rent Bands</div>
      <multi-select
        class="m-1"
        :model-value="modelValue.bands"
        @update:model-value="update('bands', $event)"
        :options="bands"
      ></multi-select>
    </div>
    <div class="mb-3">
      <div class="text-xl font-medium">Perks</div>
      <div class="flex flex-wrap">
        <checkbox-chip
          class="m-1"
          :disabled="anyPerks"
          :model-value="anyPerks"
          icon="done_all"
          @update:model-value="toggleAny()"
          >Any</checkbox-chip
        >
        <checkbox-chip
          class="m-1"
          v-for="perk in perks"
          :key="perk.id"
          :icon="perk.icon"
          :model-value="modelValue.perks.includes(perk.name)"
          @update:model-value="updatePerk(perk.name, $event)"
        >
          {{ prettify(perk.name) }}
        </checkbox-chip>
      </div>
    </div>
    <div class="mb-3 mr-10">
      <div class="text-xl font-medium">Contract</div>
      <toggle
        :model-value="modelValue.long_contract"
        @update:model-value="update('long_contract', $event)"
        first="Any"
        second="Long"
        class="bg-gray-200"
      ></toggle>
    </div>
    <div class="mb-3 mr-10">
      <div class="text-xl font-medium">Locations</div>
      <div class="flex flex-wrap">
        <checkbox-chip
          class="m-1"
          :model-value="anyLocations"
          icon="done_all"
          @update:model-value="toggleAnyLoc()"
        >
          Any
        </checkbox-chip>
        <checkbox-chip
          class="m-1"
          v-for="location in locations"
          :key="location.id"
          :model-value="modelValue.locations.includes(location.name)"
          @update:model-value="updateLoc(location.name, $event)"
        >
          {{ location.name }}
        </checkbox-chip>
      </div>
    </div>
    <div class="mb-3 mr-10">
      <div class="text-xl font-medium">Availability</div>
      <toggle
        :model-value="modelValue.available"
        @update:model-value="update('available', $event)"
        first="Any"
        second="Available"
        class="bg-gray-200"
      ></toggle>
    </div>
  </div>
</template>

<script>
import CheckboxChip from "./CheckboxChip.vue";
import MultiSelect from "./MultiSelect.vue";
import Toggle from "./Toggle.vue";
export default {
  components: { MultiSelect, CheckboxChip, Toggle },
  props: {
    modelValue: Object,
  },
  created() {
    window.api.get("/perks").then(({ data }) => {
      this.perks = data;
    });
    window.api.get("/bands").then(({ data }) => {
      this.bands = data.map((band) => ({
        name: band.number.toString(),
        value: band.number,
      }));
    });
    window.api.get("/locations").then(({ data }) => {
      this.locations = data;
    });
  },
  emits: ['update:modelValue'],
  data() {
    return {
      perks: [],
      bands: [],
      locations: [],
    };
  },
  computed: {
    anyPerks() {
      return this.modelValue.perks.length === 0;
    },
    anyLocations() {
      return this.locations.every((l) => this.modelValue.locations.includes(l.name));
    },
  },
  methods: {
    prettify(perk) {
      return perk
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    },
    update(key, value) {
      this.$emit("update:modelValue", { ...this.modelValue, [key]: value });
    },
    updatePerk(key, value) {
      let perks = [...this.modelValue.perks];
      if (value) {
        perks.push(key);
      } else {
        let index = perks.indexOf(key);
        if (index !== -1) {
          perks.splice(index, 1);
        }
      }
      this.$emit("update:modelValue", {
        ...this.modelValue,
        perks
      });
    },
    updateLoc(key, value) {
      let locations = [...this.modelValue.locations];
      if (value) {
        locations.push(key);
      } else {
        let index = locations.indexOf(key);
        if (index !== -1) {
          locations.splice(index, 1);
        }
      }
      this.$emit("update:modelValue", {
        ...this.modelValue,
        locations
      });
    },
    toggleAny() {
      this.$emit("update:modelValue", {
        ...this.modelValue,
        perks: [],
      });
    },
    toggleAnyLoc() {
      if (this.anyLocations) {
        this.$emit("update:modelValue", {
          ...this.modelValue,
          locations: [],
        });
      } else {
        this.$emit("update:modelValue", {
          ...this.modelValue,
          locations: this.locations.map(l => l.name)
        });
      }
    },
  },
};
</script>