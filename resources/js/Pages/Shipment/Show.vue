<script setup>
import Layout from "@/Layouts/Layout.vue";
import {computed, reactive, ref} from "vue";
import HistoryNav from "@/Pages/Shipment/Partials/Panels/HistoryNav.vue";
import ShipmentForm from "@/Pages/Shipment/Partials/Forms/ShipmentForm.vue";
import StopForm from "@/Pages/Shipment/Partials/Forms/StopForm.vue";
import MembersForm from "@/Pages/Shipment/Partials/Forms/MembersForm.vue";
import ResizablePanel from "@/Components/Panels/ResizablePanel.vue";
import ModifyShipment from "@/Pages/Shipment/Partials/Shipment/ModifyShipment.vue";
import ShipmentDetails from "@/Pages/Shipment/Partials/Shipment/ShipmentDetails.vue";
import Members from "@/Pages/Shipment/Partials/Members/Members.vue";
import ShipmentNotes from "@/Pages/Shipment/Partials/Shipment/ShipmentNotes.vue";
import Stop from "@/Pages/Shipment/Partials/Stop.vue";
import ShipmentChat from "@/Pages/Shipment/Partials/Chat/ShipmentChat.vue";
import Map from "@/Pages/Shipment/Partials/Map.vue";

const props = defineProps({
    shipment: Object
})

const sortedStops = computed(() => {
    return props.shipment.stops.sort(function (a, b) {
        if (a.datetime > b.datetime) {
            return 1;
        }
        if (a.datetime < b.datetime) {
            return -1;
        }
        return 0;
    })
})

const title = computed(() => '# ' + props.shipment.order_id.toUpperCase())

const chat = ref(false)

const forms = reactive({
    shipment: null,
    stop: null,
    members: null,
    createShipment() {
        this.shipment = {method: 'create'}
    },
    updateShipment() {
        this.shipment = {...props.shipment, method: 'update'}
    },
    deleteShipment() {
        this.shipment = {...props.shipment, method: 'delete'}
    },
    createStop() {
        this.stop = {'shipment_id': props.shipment.id, method: 'create'}
    },
    updateStop(stop) {
        this.stop = {...stop, method: 'update'}
    },
    deleteStop(stop) {
        this.stop = {...stop, method: 'delete'}
    },
    editMembers(members, role) {
        this.members = {'shipment_id': props.shipment.id, items: members, role: role}
    },
    deleteMember(shipment) {

    },
})

</script>

<template>
    <Layout :title="title" :slots="['INFO', 'MAP', 'CHAT']" v-slot="{viewport, slot}">

        <ShipmentForm :shipment="forms.shipment" @close="forms.shipment = null"/>
        <StopForm :stop="forms.stop" @close="forms.stop = null"/>
        <MembersForm :members="forms.members" @close="forms.members = null"/>

        <div class="h-full overflow-hidden flex flex-col">
            <HistoryNav class="-md:hidden"/>

            <div class="md:flex h-full overflow-hidden">
                <ResizablePanel v-if="slot === 'INFO' || viewport.desktop">

                    <ModifyShipment
                        :order_id="shipment.order_id"
                        @create-stop="forms.createStop()"
                        @update-shipment="forms.updateShipment()"
                        @delete-shipment="forms.deleteShipment()"
                        @create-shipment="forms.createShipment()"
                        @open-chat="openChat = true"
                    />

                    <ShipmentDetails :shipment="shipment"/>
                    <ShipmentNotes :notes="shipment.notes"/>

                    <div class="flex-grow overflow-y-auto ">
                        <Members
                            :shipment="shipment"
                            @edit-members="(members, role)=>forms.editMembers(members, role)"
                        />

                        <Stop
                            v-for="(stop, index) in sortedStops"
                            :stop="stop"
                            :index="index + 1"
                            @destroy="forms.deleteStop(stop)"
                            @edit="forms.updateStop(stop)"
                        />

                        <div v-if="!shipment.stops.length" class="p-2 text-white">
                            No stops here, please add ...
                        </div>
                    </div>

                </ResizablePanel>

                <div class="md:flex-grow h-full" :class="{'hidden': slot !== 'MAP' && viewport.mobile}">
                    <Map :shipment="shipment"/>
                </div>

                <ShipmentChat
                    :viewport="viewport"
                    :slot="slot"
                    :comments="shipment.comments"
                    :shipment_id="shipment.id"
                    :show="chat"
                    @close="chat = false"
                    @open="chat = true"
                />
            </div>

        </div>

    </Layout>
</template>

