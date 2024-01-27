<script setup>
defineProps({
    name: String
})
</script>

<template>
    <div
        class="text-center bg-gray-600 hover:bg-gray-800 hover:cursor-pointer
                -md:p-3 p-1 border border-gray-600 my-1 text-white"
    >
        {{ name }}
        <slot/>
    </div>
</template>

<style scoped>

</style>
