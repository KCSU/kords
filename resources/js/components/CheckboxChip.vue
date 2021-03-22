<template>
    <div class="flex items-center transition-colors duration-150 rounded-md text-sm cursor-default" @click="toggle()"
    :class="{'bg-purple-600 text-white': value, 'bg-gray-200': !value, 'cursor-pointer': !disabled}">
        <i v-if="!!icon" class="pl-2 material-icons-round text-msm">{{ icon }}</i>
        <span class="px-2 py-1">
            <slot></slot>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        value: Boolean,
        disabled: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        toggle() {
            this.$emit('input', !this.value);
        }
    }
}
</script>

<style scoped>
.text-msm {
    font-size: 1rem;
}
</style>