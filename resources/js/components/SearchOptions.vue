<template>
  <div
    class="absolute top-20 mt-2 z-20 shadow-xl rounded-lg p-5 w-full bg-white border border-gray-300 flex flex-wrap"
  >
    <div class="mr-10 mb-3">
      <div class="text-xl font-medium">Rent Bands</div>
      <multi-select
        class="m-1"
        :value="value.bands"
        @input="update('bands', $event)"
        :options="bands"
      ></multi-select>
    </div>
    <div class="mb-3">
      <div class="text-xl font-medium">Perks</div>
      <div class="flex flex-wrap">
        <checkbox-chip
          class="m-1"
          :disabled="anyPerks"
          :value="anyPerks"
          icon="done_all"
          @input="toggleAny()"
          >Any</checkbox-chip
        >
        <checkbox-chip
          class="m-1"
          v-for="perk in perks"
          :key="perk.id"
          :icon="perk.icon"
          :value="value.perks[perk.name]"
          @input="updatePerk(perk.name, $event)"
        >
          {{ perk.name | prettify }}
        </checkbox-chip>
      </div>
    </div>
    <div class="mb-3 mr-10">
      <div class="text-xl font-medium">Contract</div>
      <toggle
        :value="value.long_contract"
        @input="update('long_contract', $event)"
        first="Any"
        second="Long"
        class="bg-gray-200"
      ></toggle>
    </div>
    <div class="mb-3">
      <div class="text-xl font-medium">Locations</div>
      <div class="flex flex-wrap">
        <checkbox-chip
          class="m-1"
          :value="anyLocations"
          icon="done_all"
          @input="toggleAnyLoc()"
        >
          Any
        </checkbox-chip>
        <checkbox-chip
          class="m-1"
          v-for="location in locations"
          :key="location.id"
          :value="value.locations[location.name]"
          @input="updateLoc(location.name, $event)"
        >
          {{ location.name }}
        </checkbox-chip>
      </div>
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
    value: Object,
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
  filters: {
    prettify(perk) {
      return perk
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    },
  },
  data() {
    return {
      perks: [],
      bands: [],
      locations: [],
    };
  },
  computed: {
    anyPerks() {
      return !this.perks.some((p) => this.value.perks[p.name]);
    },
    anyLocations() {
      return this.locations.every((l) => this.value.locations[l.name]);
    },
  },
  methods: {
    update(key, value) {
      this.$emit("input", { ...this.value, [key]: value });
    },
    updatePerk(key, value) {
      this.$emit("input", {
        ...this.value,
        perks: {
          ...this.value.perks,
          [key]: value,
        },
      });
    },
    updateLoc(key, value) {
      this.$emit("input", {
        ...this.value,
        locations: {
          ...this.value.locations,
          [key]: value,
        },
      });
    },
    toggleAny() {
      this.$emit("input", {
        ...this.value,
        perks: {},
      });
    },
    toggleAnyLoc() {
      if (this.anyLocations) {
        this.$emit("input", {
          ...this.value,
          locations: {},
        });
      } else {
        let locs = {};
        this.locations.forEach((l) => {
          locs[l.name] = true;
        });
        this.$emit("input", {
          ...this.value,
          locations: locs,
        });
      }
    },
  },
};
</script>