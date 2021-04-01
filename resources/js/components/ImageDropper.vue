<template>
  <div
    class="h-36 rounded-xl border-gray-300 border-2 border-dashed flex-1 m-3 text-gray-500 relative cursor-pointer"
    @drop.prevent="dropped"
    @dragover.prevent
    @dragenter="drop = !loading"
    @dragleave="drop = false"
    @click="openFileDialog"
  >
    <div class="w-full h-full flex justify-center items-center pointer-events-none">
      <transition name="swipe">
        <span key="c" v-if="loading" class="absolute swipe-c">Uploading...</span>
        <span key="b" v-else-if="drop" class="absolute swipe-b">Drop file here</span>
        <span key="a" v-else class="absolute swipe-a">+ Add Images</span>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      drop: false,
    };
  },
  methods: {
    dropped(ev) {
      if (this.loading) return;
      this.drop = false;
      if (ev.dataTransfer) {
        let files = Array.from(ev.dataTransfer.files);
        if (!files.every(f => f.type.match('image.*'))) {
          return;
        }
        this.$emit('input', files);
      }
    },
    openFileDialog() {
      if (this.loading) return;
      let inEl = document.createElement('input');
      inEl.type = 'file'
      inEl.accept = 'image/*';
      inEl.multiple = true;
      inEl.onchange = (ev) => {
        let files = Array.from(ev.target.files);
        if (!files.every(f => f.type.match('image.*'))) {
          return;
        }
        this.$emit('input', files);
      }
      inEl.click();
    }
  },
};
</script>

<style scoped>
.swipe-enter-active,
.swipe-leave-active {
  transition: opacity 0.15s, transform 0.15s;
}
.swipe-a.swipe-enter, .swipe-a.swipe-leave-to /* .swipe-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(-50px);
}

.swipe-b.swipe-enter, .swipe-b.swipe-leave-to /* .swipe-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(50px);
}

.swipe-c.swipe-enter /* .swipe-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(-50px);
}

.swipe-c.swipe-leave-to {
  opacity: 0;
  transform: translateY(50px);
}
</style>