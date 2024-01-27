<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="autofill:selec border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600
       rounded-md shadow-sm "
        v-model="model"
        ref="input"
    />
</template>
