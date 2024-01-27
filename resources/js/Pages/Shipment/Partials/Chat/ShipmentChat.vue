<script setup>
import ChatTrigger from "@/Pages/Shipment/Partials/Chat/ChatTrigger.vue";
import Modal from "@/Components/Modals/Modal.vue";
import ChatWindow from "@/Pages/Shipment/Partials/Chat/ChatWindow.vue";

defineProps({
    viewport: Object,
    show: Boolean,
    comments: Array,
    shipment_id: Number,
    slot: String
})

defineEmits(['close', 'open'])

</script>

<template>
    <div class="h-full">

        <div v-if="viewport?.desktop">
            <ChatTrigger @click="$emit('open')"/>

            <Modal :show="show" @close="$emit('close')" position="chat" >
                <ChatWindow
                    :comments="comments"
                    :shipment-id="shipment_id"
                    class="h-[40rem] w-[40rem] border border-gray-600 main-rounded"
                />
            </Modal>
        </div>

        <ChatWindow v-else-if="slot === 'CHAT' && viewport?.mobile"
                    :comments="comments"
                    :shipment-id="shipment_id"
        />

    </div>
</template>
