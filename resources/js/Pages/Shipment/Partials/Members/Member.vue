<script setup>
import Initials from "@/Components/Icons/Initials.vue";
import SvgStatusDone from "@/Components/Icons/SvgStatusDone.vue";
import SvgStatusInProgress from "@/Components/Icons/SvgStatusInProgress.vue";

defineProps({
    name: String,
    newMember: Boolean,
    confirmed: Boolean,
    inProgress: Boolean
})

</script>

<template>
    <div class="flex items-center rounded-md hover:bg-gray-700 hover:cursor-pointer space-x-1 p-2">
        <Initials :name="name" :new-member="newMember"/>
        <span :class="{'text-gray-400': newMember}">{{ name }}</span>

        <div v-if="confirmed || inProgress" class="flex-grow flex justify-end">
            <svg-status-done v-if="confirmed" class="w-6"/>
            <svg-status-in-progress v-if="inProgress" class="w-6"/>
        </div>
    </div>
</template>

<style scoped>

</style>
