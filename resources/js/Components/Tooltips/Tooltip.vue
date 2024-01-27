<script setup>
import {computed} from "vue";

const props = defineProps({
    text: String
})

const upperCaseText = computed(() => {
    return props.text ? props.text.toUpperCase() : 'add text'
})

</script>

<template>
    <div class="hidden md:block absolute top-[50%] left-full -translate-y-1/2 translate-x-4
                z-30 p-3
                text-black font-bold text-md whitespace-nowrap
                pointer-events-none bg-gray-200 rounded-lg
                opacity-0 transition-opacity group-hover:opacity-100 shadow-xl tooltip-arrow-left "
    >
        {{ upperCaseText }}
    </div>
</template>

