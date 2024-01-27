<script setup>
defineProps({
    title: String,
    gridDevided: {
        type: Boolean,
        default: false
    },
    gridReverse: {
        type: Boolean,
        default: false
    },
    h: Number
})
</script>

<template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-3 text-gray-500 dark:text-gray-400 relative">

        <p v-show="title !== undefined" class="mb-3 border-b border-gray-600 text-white pb-2">{{ title }}</p>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50
            dark:via-transparent dark:border-gray-700">

                <slot></slot>

            </div>

        </div>

    </div>


</template>
