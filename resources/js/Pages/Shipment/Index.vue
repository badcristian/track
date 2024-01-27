<script setup>
import Layout from "@/Layouts/Layout.vue";
import {reactive} from "vue";
import ShipmentForm from "@/Pages/Shipment/Partials/Forms/ShipmentForm.vue";
import ResizablePanel from "@/Components/Panels/ResizablePanel.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import Pagination from "@/Pages/Shipment/Partials/Pagination.vue";
import Filter from "@/Pages/Shipment/Partials/Filter.vue";
import Shipment from "@/Pages/Shipment/Partials/Shipment/Shipment.vue";
import Map from "@/Pages/Shipment/Partials/Map.vue";

const props = defineProps({
    shipments: Object,
    filters: Object
})

const form = reactive({
    shipment: null,
    create() {
        this.shipment = {method: 'create'}
    },
    update(shipment) {
        this.shipment = {...shipment, method: 'update'}
    },
    delete(shipment) {
        this.shipment = {...shipment, method: 'delete'}
    },
})
</script>

<template>
    <Layout title="Shipments">
        <ShipmentForm :shipment="form.shipment" @close="form.shipment = null"/>

        <div class="md:flex overflow-hidden">
            <ResizablePanel>
                <div class="mx-4 mt-2">
                    <main-button class="" @click="form.create()">
                        <!--                       <svg-add-button class="w-6" />-->
                        Add Shipment
                    </main-button>
                </div>

                <Filter :props-filters="filters"/>

                <div class="flex-grow overflow-y-auto">
                    <Shipment v-for="shipment in shipments.data"
                              :shipment="shipment"
                              @update="(data)=>form.update(data)"
                              @delete="(data)=>form.delete(data)"
                    />

                </div>
                <Pagination :data="shipments" class="pb-2"/>
            </ResizablePanel>

            <div class="md:flex-grow">
                <Map />
            </div>
        </div>
    </Layout>
</template>
