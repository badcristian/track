<script setup>
import SvgStatusDone from "@/Pages/Shipment/Partials/Icons/SvgStatusDone.vue";
import {computed} from "vue";
import {randomIntFromInterval} from "@/helpers.js";
import SvgStatusCancelled from "@/Pages/Shipment/Partials/Icons/SvgStatusCancelled.vue";
import SvgStatusInProgress from "@/Pages/Shipment/Partials/Icons/SvgStatusInProgress.vue";

defineProps({
    status: String
})

let rand = computed(()=>{
    return randomIntFromInterval(0,2)
})

</script>

<template>
    <div class="group relative z-30">
        <svg-status-done v-show="rand===0" class="w-7 " />
        <svg-status-cancelled v-show="rand===1" class="w-7 " />
        <svg-status-in-progress v-show="rand===2" class="w-7 " />

<!--        <div class="hidden md:block p-1 rounded-md border border-gray-500">-->
<!--            {{rand == 0 ? status.toUpperCase() : rand == 1 ? 'CANCELLED' : 'DONE'}}-->
<!--        </div>-->
        <span class="absolute z-20 bg-gray-700 rounded-lg p-3 text-sm whitespace-nowrap w-max opacity-0
                    transition-opacity group-hover:opacity-100 shadow-xl shadow-black/10">
            {{ status }}
        </span>
    </div>
</template>
