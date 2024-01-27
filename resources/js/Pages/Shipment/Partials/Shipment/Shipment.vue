<script setup>
import {computed} from "vue";
import {Link} from '@inertiajs/vue3';
import {getDate} from "@/helpers.js";
import SvgDeleteIcon from "@/Components/Icons/SvgDeleteIcon.vue";
import SvgEditIcon from "@/Components/Icons/SvgEditIcon.vue";

const props = defineProps({
    shipment: Object,
})

defineEmits(['delete', 'update'])

const info = computed(() => {
    const first = props.shipment.margin_stops[0]
    const last = props.shipment.margin_stops[1]
    let locations = ''
    let dates = ''
    if (first) {
        locations += `${first.city}, ${first.state}`
        dates += `Dates: ${getDate(first.datetime)}`
    }
    if (last) {
        locations += ` - ${last.city}, ${last.state}`
        dates += ` - ${getDate(last.datetime)}`
    } else {
        locations = 'No stops added yet'
    }
    return {locations: locations, dates: dates}
})

const details = computed(() => {
    return [
        {value: `#${props.shipment.order_id}`, truncate: false},
        {value: props.shipment.company.name, truncate: true},
        {value: `${Math.round(props.shipment.weight / 1000)} KLB`, truncate: false},
        {value: `${Math.round(props.shipment.temperature)} F`, truncate: false},
    ]
})

</script>
<template>

    <div class="p-2 md:p-4 hover:bg-gray-700 hover:text-white border-b
                border-gray-600 flex justify-between overflow-x-hidden"
    >

        <Link :href="'/shipments/' + shipment.id" class=" flex-grow">
            <div class="p-1 text-white">
                {{ info.locations }}

                <div class="text-gray-400">
                    {{ info.dates }}
                </div>
            </div>

            <div class="flex text-gray-400">
                <div v-for="item in details"
                     class="border border-gray-400 px-1 mt-2 mr-2 rounded-md whitespace-nowrap"
                     :class="{'truncate': item.truncate}"
                >
                    {{ item.value }}
                </div>
            </div>
        </Link>


        <div class="flex flex-col">
            <div class="flex-grow group hover:cursor-pointer">
                <SvgEditIcon
                    class="w-7 p-1 rounded-md group-hover:bg-gray-500"
                    @click="$emit('update', shipment)"
                />
            </div>
            <div class="flex-grow flex items-end group hover:cursor-pointer">
                <SvgDeleteIcon
                    class="w-7 p-1 rounded-md group-hover:bg-gray-500 "
                    @click="$emit('delete', shipment)"
                />
            </div>
        </div>

    </div>

</template>

