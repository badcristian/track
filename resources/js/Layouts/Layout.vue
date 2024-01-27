<script setup>
import {ref} from "vue";
import {Head} from "@inertiajs/vue3";
import {useBreakpoints} from "@/Components/Composables/UseBreakpoints.js";
import Banner from "@/Components/Banners/Banner.vue";
import NavLeftDesktop from "@/Components/Navigation/NavLeftDesktop.vue";
import NavLeftMobile from "@/Components/Navigation/NavLeftMobile.vue";
import NavTopMobile from "@/Components/Navigation/NavTopMobile.vue";
import NavBottomMobile from "@/Components/Navigation/NavBottomMobile.vue";

const props = defineProps({
    title: String,
    slots: Array,
    selectedSlot: String
})

let show = ref(false)
const slot = ref(props.slots ? props.slots[0] : '')
const {mobile, desktop} = useBreakpoints()

</script>

<template>
    <div class="h-full overflow-hidden bg-gray-400">
        <Head :title="title"/>
        <Banner/>

        <div class="-md:h-screen md:h-full grid -md:grid-rows-[auto_1fr] md:grid-cols-[auto_1fr]">
            <NavLeftDesktop class="-md:hidden"/>
            <NavLeftMobile class="md:hidden" :show="show && mobile" @close="show = !show"/>
            <NavTopMobile class="md:hidden" v-model="show"/>

            <slot :viewport="{mobile, desktop}" :slot="slot"/>

            <NavBottomMobile
                v-if="slots"
                class="md:hidden"
                :slots="slots"
                :selected="slot"
                @change="(newSlot)=>slot = newSlot"
            />
        </div>
    </div>
</template>

<style>
html, body, #app {
    height: 100%;
    width: 100%;
    margin: 0;
}
</style>
