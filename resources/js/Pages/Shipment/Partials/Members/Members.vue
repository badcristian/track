<script setup>
import {computed} from "vue";
import Member from "@/Pages/Shipment/Partials/Members/Member.vue";

const props = defineProps({
    shipment: Object
})

defineEmits(['editMembers'])

const members = computed(() => {
    let members = {
        brokers: [],
        drivers: [],
        dispatchers: []
    }
    props.shipment.members.forEach((member) => {
        if (member.pivot.role == 'driver') members.drivers.push(member)
        if (member.pivot.role == 'broker') members.brokers.push(member)
        if (member.pivot.role == 'dispatcher') members.dispatchers.push(member)
    })
    return members
})

</script>

<template>
    <div class="gradient-bl p-2 space-y-3 border-b border-gray-600">
        <div class="space-y-1 text-white">

            <div class="grid grid-cols-2 md:grid-cols-7 border-b border-gray-600 border-opacity-60 pb-2">
                <div class="md:col-span-4 ">Brokers:</div>

                <div class="md:col-span-3 ">
                    <Member
                        v-for="broker in members.brokers"
                        :name="broker.name"
                        @click="$emit('editMembers', members.brokers, 'broker')"
                    />
                    <Member
                        name="add/edit a brokers"
                        new-member
                        @click="$emit('editMembers', members.brokers, 'broker')"
                    />
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-7 border-b border-gray-600 border-opacity pb-2">
                <div class="md:col-span-4 ">Dispatchers:</div>

                <div class="md:col-span-3 ">
                    <Member
                        v-for="dispatcher in members.dispatchers"
                        :name="dispatcher.name"
                        @click="$emit('editMembers', members.dispatchers, 'dispatcher')"
                    />
                    <Member
                        name="add/edit a dispatchers"
                        new-member
                        @click="$emit('editMembers', members.dispatchers, 'dispatcher')"
                    />
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-7 ">
                <div class="md:col-span-4 ">Drivers:</div>

                <div class="md:col-span-3 ">
                    <Member
                        v-for="driver in members.drivers"
                        :name="driver.name"
                        @click="$emit('editMembers', members.drivers, 'driver')"
                    />
                    <Member
                        name="add/edit a drivers"
                        new-member
                        @click="$emit('editMembers', members.drivers, 'driver')"
                    />
                </div>
            </div>

        </div>
    </div>
</template>
