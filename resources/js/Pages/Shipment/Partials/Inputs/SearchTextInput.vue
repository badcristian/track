<script setup>
import {onMounted, ref} from 'vue';
import SvgSearchIcon from "@/Components/Icons/SvgSearchIcon.vue";

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>

    <div class="bg-transparent border-none p-0 relative flex items-center">

        <svg-search-icon class="w-4 left-3 absolute" />

        <input
            ref="input"
            type="text"
            class="pl-8 bg-gray-700 border-gray-600 rounded-md w-full h-full focus:bg-gray-800 shadow-sm placeholder-gray-200"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            placeholder="search..."
        >
    </div>

</template>



