<template>
  <div class="flex rounded-xl text-xs items-center px-3" :class="toggled ? 'bg-green-200' : 'bg-red-200'">
    <div class="w-1.5 h-1.5 rounded-lg" :class="toggled ? 'bg-green-600' : 'bg-red-600'"></div>
    <div class="ml-2 font-bold my-1" :class="toggled ? 'text-green-600' : 'text-red-600'">
        {{ toggled ? active : inactive }}
    </div>
  </div>
</template>

<script>
export default {
    props: {
        toggled: Boolean,
        active: String,
        inactive: String
    }
}
</script>