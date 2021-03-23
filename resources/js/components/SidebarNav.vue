<template>
  <aside
    class="z-20 w-64 h-full overflow-y-auto bg-white md:block flex-shrink-0 border-r border-gray-200"
  >
    <div class="py-4 text-gray-500">
      <a class="ml-6 text-4xl font-bold text-gray-800" href="#"> KORDs </a>
      <ul class="mt-6">
        <li
          v-for="(item, i) in items"
          :key="`item-${i}`"
          class="relative px-6 py-3 flex items-center cursor-pointer hover:text-gray-800"
          :class="item.id == value ? 'text-gray-800' : 'text-gray-500'"
          @click="$emit('input', item.id)"
        >
          <span
            class="pl-4 h-8 inline-flex items-center w-full text-sm font-semibold transition-colors duration-150"
          >
            <i
              class="text-xl transition-colors duration-150 lni"
              :class="`lni-${item.icon} ${
                item.id == value ? 'text-purple-600' : ''
              }`"
            ></i>
            <span class="ml-4">{{ item.name }}</span>
          </span>
          <span
            class="absolute inset-y-2 right-0 bg-purple-600 w-0 rounded-tl-lg rounded-bl-lg transition-width duration-150"
            :class="item.id == value ? 'w-1' : ''"
            aria-hidden="true"
          ></span>
        </li>
        <li class="relative px-6 py-3 w-full hover:text-gray-800">
          <div
            class="flex items-center cursor-pointer justify-between"
            @click="submenuOpen = !submenuOpen"
          >
            <span
              class="pl-4 h-8 inline-flex items-center text-sm font-semibold transition-colors duration-150"
            >
              <i class="text-xl lni lni-more-alt"></i>
              <span class="ml-4">More Options</span>
            </span>
            <!-- <i class="lni lni-chevron-down text-xs"></i> -->
            <svg
              class="w-4 h-4"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <transition-expand>
            <ul
              v-if="submenuOpen"
              class="mt-2 overflow-hidden -space-y-4 text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-100"
              aria-label="submenu"
            >
              <li
                v-for="(item, i) in subItems"
                :key="`sub-${i}`"
                class="px-4 py-4 transition-colors duration-150"
                :class="item.id == value ? 'text-purple-600' : 'hover:text-gray-800'"
              >
                <a class="w-full cursor-pointer" @click="$emit('input', item.id)">{{ item.name }}</a>
              </li>
            </ul>
          </transition-expand>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import TransitionExpand from "./TransitionExpand";

export default {
  name: "SidebarNav",
  components: { TransitionExpand },
  props: {
    items: Array,
    subItems: Array,
    value: String,
  },
  data() {
    return {
      submenuOpen: false,
    };
  },
};
</script>