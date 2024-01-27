<script setup>
import {onBeforeMount} from "vue";

const props = defineProps({
    modelValue: Number,
    title: String
})

const emit = defineEmits(['update:modelValue']);

onBeforeMount(() => {
    if (props.modelValue !== 1 && props.modelValue !== 0) {
        emit('update:modelValue', 1)
    }
})

</script>

<template>

    <div class="flex w-full space-x-2">
        <div
            class="border border-gray-600 rounded-md p-2 hover:bg-gray-600 w-full whitespace-nowrap flex justify-center"
            :class="[modelValue === 1 ? 'bg-gray-700' : 'bg-slate-900']"
            @click="$emit('update:modelValue', 1)"
        >
            <div class="rounded-md cursor-pointer">
                FCFS<span :class="{'opacity-0': modelValue === 0}" class="text-green-500 p-1">✓</span>
            </div>
        </div>

        <div
            class="border border-gray-600 rounded-md p-2 hover:bg-gray-700 w-full whitespace-nowrap flex justify-center"
            :class="[modelValue === 0 ? 'bg-gray-700' : 'bg-slate-900']"
            @click="$emit('update:modelValue', 0)"
        >
            <div class="rounded-md cursor-pointer">
                BY APPT <span :class="{'opacity-0': modelValue === 1}" class="text-green-500 p-1">✓</span>
            </div>

        </div>
    </div>
</template>
