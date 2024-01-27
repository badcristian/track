<script setup>
import {computed} from "vue";
import {formatTime, formatTimeRange} from "@/helpers.js";
import SvgEditIcon from "@/Components/Icons/SvgEditIcon.vue";
import SvgLocationIcon from "@/Components/Icons/SvgLocationIcon.vue";
import SvgOrganization from "@/Components/Icons/SvgOrganization.vue";
import SvgTimeIcon from "@/Components/Icons/SvgTimeIcon.vue";
import SvgDeleteIcon from "@/Components/Icons/SvgDeleteIcon.vue";

const props = defineProps({
    stop: Object,
    index: Number
})

defineEmits(['destroy', 'edit'])

const address = computed(() => {
    return `${props.stop.street_address}, ${props.stop.city}, ${props.stop.state}, ${props.stop.zip_code}`
})

const time = computed(() => {
    if (Number(props.stop.fcfs)) {
        return `${formatTimeRange(props.stop.working_hours_start, props.stop.working_hours_end)} FCFS`
    } else {
        return formatTime(props.stop.datetime)
    }
})

const eta = computed(() => {
    return formatTime(props.stop.eta)
})


const departure = computed(() => {
    return formatTime(props.stop.departure_datetime)
})

</script>

<template>
    <div class="p-2 bg-gray-800 cursor-pointer hover:bg-gray-700
            flex justify-between gradient-tr border-b border-gray-600"
    >

        <div class="space-y-1 text-white flex-grow text-center" @click="$emit('edit', stop)">

            <div>
                <span class=" border border-gray-600 rounded-md py-1 px-2">Stop Number: {{ index ?? '' }}</span>
            </div>

            <div class="flex space-x-2 items-center">
                <SvgOrganization class="w-8 rounded-md border border-gray-600 p-1"/>
                <div>
                    {{ stop.name.toUpperCase() }}
                </div>
            </div>

            <div class="flex space-x-2 items-center">
                <SvgLocationIcon class="w-8 rounded-md border border-gray-600 p-1"/>
                <div>
                    {{ address }}
                </div>
            </div>


            <div class="flex space-x-2 items-center">
                <SvgTimeIcon class="w-8 rounded-md border border-gray-600 p-1"/>
                <div>
                    {{ time }}
                </div>
            </div>

            <div class="flex space-x-2 items-center">
                <div class="w-8 rounded-md border border-gray-600 p-1 flex justify-center text-sm">
                    ETA
                </div>
                <div>
                    {{ eta }}
                </div>
            </div>


            <div class="flex space-x-2 items-center">
                <div class="w-8 rounded-md border border-gray-600 p-1 flex justify-center text-sm">
                    DPR
                </div>
                <div>
                    {{ departure }} (departure)
                </div>
            </div>

        </div>

        <div class="flex flex-col justify-between">

            <SvgEditIcon class="w-10 p-2 rounded-md hover:bg-gray-500"/>

            <div class="flex-grow" @click="$emit('edit')">
            </div>

            <SvgDeleteIcon
                class="w-10 p-2 rounded-md hover:bg-gray-500 hover:cursor-pointer"
                @click="$emit('destroy')"
            />
        </div>
    </div>

</template>
