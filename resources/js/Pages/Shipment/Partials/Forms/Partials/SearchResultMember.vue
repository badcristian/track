<script setup>
defineProps({
    member: Object
})
</script>

<template>
    <div class="hover:bg-gray-500 hover:cursor-pointer p-1 truncate px-1">
        {{ member.name }}
        <span class="text-sm text-gray-300 ">
            {{ member.email ?? '' }}
        </span>
    </div>
</template>

<style scoped>

</style>
