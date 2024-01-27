<script setup>
import {Link} from "@inertiajs/vue3";
import Tooltip from "@/Components/Tooltips/Tooltip.vue";

const props = defineProps({
    href: String,
    text: String,
    showText: Boolean,
    active: Boolean,
    disableTooltip: Boolean
})

</script>

<template>
    <div class="group relative mx-2">

        <!--        IF IS A LINK-->
        <Link
            v-if="href"
            :href="href"
            class="p-2 rounded-md hover:bg-gray-600 cursor-pointer text-gray-200
                   active:bg-gray-700 active:border-indigo-600 disabled:opacity-50
                   disabled:pointer-events-none transition-all flex"
            :class="{'main-active-bg': active}">

            <div class="w-6">
                <slot/>
            </div>

            <div class="truncate transition-all duration-100 ease-linear"
                 :class="[showText ? 'w-[200px] pl-3 ' : 'w-[0px]']"
            >
                {{ text }}
            </div>
        </Link>

        <!--        IF IS NOT A LINK-->
        <div v-else class="p-2 border border-gray-700 rounded-md hover:bg-gray-600 cursor-pointer text-gray-200
                   active:bg-gray-700 active:border-indigo-600 disabled:opacity-50
                   disabled:pointer-events-none transition-all flex">

            <div class="w-6">
                <slot/>
            </div>

            <div class="truncate transition-all duration-100 ease-linear"
                 :class="[showText ? 'w-[200px] pl-3 ' : 'w-[0px]']"
            >
                {{ text }}
            </div>
        </div>

        <Tooltip v-show="!showText && !disableTooltip" :text="text"/>
    </div>
</template>
