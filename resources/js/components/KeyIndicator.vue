<template>
    <kbd class="px-1 py-0.5 border-gray-300 border rounded-md cursor-pointer" :class="{'keydown' : pressed}">
        <slot></slot>
    </kbd>
</template>

<script>
export default {
    props: {
        pressed: Boolean
    }
}
</script>

<style scoped>
.rounded-md {
    border-radius: 4px
}

kbd {
  box-shadow: 0 3px 0 -1px white, 0 3px 0 0px #D1D5DB;
}

kbd.keydown {
    box-shadow: none;
    transform: translateY(3px);
}
</style>