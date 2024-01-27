<script setup>
defineProps({
    modelValue: String,
    placeholder: String,
    error: String,
    label: String
})

defineEmits(['update:modelValue']);

</script>

<template>
    <div>
        <label>
            {{label ?? 'Notes'}}
            <textarea
                id="notes"
                class="border-gray-600 bg-gray-900 text-gray-300 focus:border-blue-500
                   focus:ring-gray-600 rounded-md shadow-sm w-full md:min-w-[15rem]"
                :value="modelValue"
                :placeholder="placeholder"
                :class="{'border-red-500': error}"
            />
            <span class="text-red-500" v-show="error">{{ error }}</span>
        </label>
    </div>
</template>

<style scoped>

</style>
