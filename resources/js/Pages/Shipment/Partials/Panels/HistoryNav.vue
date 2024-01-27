<script setup>
import SvgSmallArrow from "@/Components/Icons/SvgSmallArrow.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="bg-gray-800 p-2 flex justify-between border-b border-gray-600">
        <Link :href="$page.props.urlPrevious ?? route('home')">
            <MainButton class="flex items-center" tooltip-text="Back">
                <svg-small-arrow class="h-[1rem] rotate-90 "/>
                Back
            </MainButton>
        </Link>
        <MainButton>button</MainButton>
    </div>
</template>
