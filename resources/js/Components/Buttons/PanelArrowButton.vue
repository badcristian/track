<script setup>
import SvgArrowOpenPanel from "@/Components/Icons/SvgArrowOpenPanel.vue";
import Tooltip from "@/Components/Tooltips/Tooltip.vue";

defineProps({
    modelValue: Boolean,
});

defineEmits(['update:modelValue']);

</script>

<template>
    <div @click="$emit('update:modelValue', !modelValue)" class="group absolute -right-5 bottom-0 pb-3" >
        <div class=" border border-gray-700 p-2 rounded-md bg-gray-800 hover:bg-gray-600
                    cursor-pointer text-gray-200 transition-all flex relative">
            <svg-arrow-open-panel class="w-6 " :class="{'transform rotate-180':  modelValue}"/>
            <tooltip text="toggle" />
        </div>
    </div>
</template>
