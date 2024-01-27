<script setup>
defineProps({
    shipment: Object
})
</script>

<template>
    <div class="p-2 border-b border-gray-600">
        <div class="flex justify-center space-x-3 text-white">

            <div class="border border-gray-600 rounded-md p-1">
                Status: {{ shipment.status ?? 'no status' }}
            </div>

            <div class="border border-gray-600 rounded-md p-1">
                Temperature: {{ shipment.temperature ? shipment.temperature + 'F' : 'no temp' }}
            </div>

            <div class="border border-gray-600 rounded-md p-1">
                Equipment: {{ shipment.equipment_type }}
            </div>

        </div>
    </div>

</template>
