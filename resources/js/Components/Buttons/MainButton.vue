<script setup>
import Tooltip from "@/Components/Tooltips/Tooltip.vue";

defineProps({
    tooltipText: String,
    type: {
        type: String,
        default: 'button'
    }
})

</script>

<template>
    <button :type="type"
            class="py-1 px-2 rounded-md hover:bg-gray-600 cursor-pointer text-gray-200
                    active:bg-gray-700 active:border-indigo-600
                    disabled:opacity-50 disabled:pointer-events-none border border-gray-600 "
            :class="{'relative group mr-2': tooltipText}"
    >
        <slot/>
        <tooltip v-if="tooltipText" :text="tooltipText"/>
    </button>
</template>
