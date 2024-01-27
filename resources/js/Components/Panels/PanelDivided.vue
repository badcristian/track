<script setup>

</script>

<template>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

            <div>
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl
                dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        <slot name="top"></slot>
                    </p>
                </div>

                <div class="bg-gray-200 dark:bg-gray-800
                bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        <slot name="bottom-column-one"></slot>
                    </p>

                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        <slot name="bottom-column-two"></slot>
                    </p>


                </div>
            </div>

        </div>

    </div>


</template>
