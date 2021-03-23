<template>
  <div
    tabindex="0"
    class="fixed inset-0 overflow-hidden z-30 outline-none"
    :class="{ 'pointer-events-none': !value }"
    @keydown.esc="close()"
    @keydown.left="left(true)"
    @keyup.left="left(false)"
    @keydown.right="right(true)"
    @keyup.right="right(false)"
  >
    <div class="absolute inset-0 overflow-hidden">
      <div
        class="absolute inset-0 transition-opacity duration-300 ease-in-out"
        :class="{ 'opacity-0': !value }"
        aria-hidden="true"
        @click="close()"
      ></div>
      <section
        class="absolute inset-y-0 right-0 pl-10 max-w-full flex"
        aria-labelledby="slide-over-heading"
      >
        <div
          class="relative w-screen max-w-lg transform transition ease-in-out duration-300 sm:duration-500"
          :class="{ 'translate-x-full': !value }"
        >
          <div
            class="h-full flex flex-col py-6 px-2 bg-white shadow-2xl overflow-y-auto border-l border-gray-200 rounded-l-lg"
          >
            <div class="px-4 sm:px-6 flex justify-between">
              <span class="text-sm font-medium text-gray-400 flex items-center">
                <key-indicator
                  class="mr-1"
                  :pressed="leftPressed"
                  @mousedown.native="left(true)"
                  @mouseup.native="left(false)"
                >
                  <svg
                    class="h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </key-indicator>
                <key-indicator
                  class="mr-2"
                  :pressed="rightPressed"
                  @mousedown.native="right(true)"
                  @mouseup.native="right(false)"
                >
                  <svg
                    class="h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </key-indicator>
                <span class="text-gray-500">to navigate</span>
              </span>
              <div class="flex items-center">
                <key-indicator class="mr-2" @mousedown.native="close()">
                  <div class="text-xs text-gray-400 font-bold h-5 lh-sm">
                    Esc
                  </div>
                </key-indicator>
                <span class="text-sm text-gray-500 font-medium">to close</span>
              </div>
            </div>
            <div class="mt-8 relative flex-1 px-4 sm:px-6">
              <!-- Replace with your content -->
              <!-- <div class="absolute inset-0 px-4 sm:px-6">
                <div
                  class="h-full border-2 border-dashed border-gray-200"
                  aria-hidden="true"
                ></div>
              </div> -->
              <slot></slot>
              <!-- /End replace -->
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import KeyIndicator from "./KeyIndicator";

export default {
  props: {
    value: Boolean,
    title: String,
  },
  methods: {
    close() {
      this.$emit("input", false);
    },
    left(pr) {
      this.leftPressed = pr;
      if (pr) {
        this.$emit('back');
      }
    },
    right(pr) {
      this.rightPressed = pr;
      if (pr) {
        this.$emit('next');
      }
    },
  },
  data() {
    return {
      leftPressed: false,
      rightPressed: false,
    };
  },
  components: { KeyIndicator },
};
</script>

<style scoped>
.lh-sm {
  line-height: 1.8;
}

.shadow-2xl {
  --tw-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.12);
}
</style>
