<template>
  <div class="grid justify-center items-center bg-gray-200 h-screen">
    <div class="cursor-pointer p-4 text-xl bg-white shadow-sm hover:shadow-md transition-shadow duration-150 rounded-md"
    @click="login()">
    <!-- TODO: replace laravel view with this? -->
      Login with Raven
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    login() {
    }
  }
}
</script>