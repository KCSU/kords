<template>
    <div class="flex items-center transition-colors duration-150 rounded-md text-sm cursor-pointer" @click="toggle()"
    :class="value ? 'bg-purple-600 text-white' : 'bg-gray-200'">
        <i class="px-2 material-icons-round">{{ icon }}</i>
        <span class="pr-2 py-1">
            <slot></slot>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        value: Boolean
    },
    methods: {
        toggle() {
            this.$emit('input', !this.value);
        }
    }
}
</script>