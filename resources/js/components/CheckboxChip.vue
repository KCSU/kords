<template>
    <div class="flex items-center transition-colors duration-150 rounded-md text-sm cursor-default" @click="toggle()"
    :class="{'bg-purple-600 text-white': modelValue, 'bg-gray-200': !modelValue, 'cursor-pointer': !disabled}">
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
        modelValue: Boolean,
        disabled: {
            type: Boolean,
            default: false
        }
    },
    emits: ['update:modelValue'],
    methods: {
        toggle() {
            this.$emit('update:modelValue', !this.modelValue);
        }
    }
}
</script>

<style scoped>
.text-msm {
    font-size: 1rem;
}
</style>