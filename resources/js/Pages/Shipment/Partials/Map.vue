<script setup>
import {ref} from "vue";
import {initMap} from "@/Pages/Shipment/Partials/Factories/Map.js";

const props = defineProps({
    shipment: {
        type: Object,
        default: {stops: [], driver_locations: []}
    }
})

const mapRef = ref(null)

try {
    initMap(mapRef, () => props.shipment.stops, () => props.shipment.driver_locations)
} catch (err) {
    alert(err)
}


</script>

<template>
    <div id="map" ref="mapRef" class="w-full h-full text-black">
    </div>
</template>
