<template>
    <div class="flex flex-1 items-center mr-2">
        <i class="lni text-2xl mr-2 text-gray-500" :class="`lni-${icon}`"></i>
        <div class="flex flex-col mx-2">
            <span class="text-sm text-gray-600">{{ name }}</span>
            <span class="text-md text-gray-800" :class="{'whitespace-nowrap' : nowrap }"><slot></slot></span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        icon: String,
        nowrap: Boolean
    }
}
</script>