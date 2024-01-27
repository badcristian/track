<script setup>
defineProps({
    notes: String
})
</script>

<template>
    <div class="p-2 border-b border-gray-600">
        <div class="line-clamp-5 text-white">
            <span class="text-yellow-600">Notes:</span> {{ notes }}
        </div>
    </div>
</template>

<style scoped>

</style>
