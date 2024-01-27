<script setup>
import {ref} from "vue";
import PanelArrowButton from "@/Components/Buttons/PanelArrowButton.vue";

let show = ref(true)

</script>

<template>
    <div class="h-full md:main-border-r md:min-w-[1.8rem] md:relative bg-gray-800 md:max-w-[35rem]">

        <panel-arrow-button v-model="show" class="-md:hidden z-20 "/>

        <div class="h-full flex flex-col justify-between " :class="{'md:hidden': !show}">
            <slot/>
        </div>

    </div>
</template>
