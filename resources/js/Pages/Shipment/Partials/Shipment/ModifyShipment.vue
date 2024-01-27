<script setup>
import SvgDotsIcon from "@/Components/Icons/SvgDotsIcon.vue";
import DropdownButton from "@/Components/Buttons/DropdownButton.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import SvgAddButton from "@/Components/Icons/SvgAddButton.vue";

defineProps({
    order_id: String
})

defineEmits(['createStop', 'updateShipment', 'deleteShipment', 'createShipment', 'openChat'])

</script>

<template>
    <div class="flex justify-between items-center py-2 pr-6 text-white border-b border-gray-600">

        <span class="px-2 ">Ship#: {{ order_id }}</span>

        <div class="flex">
            <MainButton tooltip-text="Add a stop" @click="$emit('createStop')">
                <SvgAddButton class="h-[1.5rem]"/>
            </MainButton>

            <Dropdown>
                <template #trigger>
                    <main-button tooltip-text="Options">
                        <SvgDotsIcon class="h-[1.5rem]"/>
                    </main-button>
                </template>

                <template #content>
                    <DropdownButton name="Add Stop" @click="$emit('createStop')" />
                    <DropdownButton name="Edit Shipment" @click="$emit('updateShipment')"/>
                    <DropdownButton name="Delete Shipment" @click="$emit('deleteShipment')"/>
                    <DropdownButton name="Add Shipment" @click="$emit('createShipment')"/>
                    <DropdownButton name="Send a Message" @click="$emit('openChat')"/>
                </template>
            </Dropdown>
        </div>

    </div>
</template>

