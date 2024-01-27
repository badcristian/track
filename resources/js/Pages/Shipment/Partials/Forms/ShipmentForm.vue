<script setup>
import {watch} from "vue";
import NProgress from "nprogress";
import FormInput from "@/Pages/Shipment/Partials/Forms/Partials/FormInput.vue";
import Modal from "@/Components/Modals/Modal.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import {capitalizeFirstLetter} from "@/helpers.js";
import FormNotes from "@/Pages/Shipment/Partials/Forms/Partials/FormNotes.vue";
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['close']);

const props = defineProps({
    shipment: Object,
})

const form = useForm({})

watch(() => props.shipment, (shipment) => {
    form.defaults({
        order_id: shipment?.order_id ?? '',
        weight: shipment?.weight ?? 0,
        temperature: shipment?.temperature ?? null,
        equipment_type: shipment?.equipment_type ?? '',
        notes: shipment?.notes ?? '',
    }).reset()
})

function submit() {
    if (props.shipment.method === 'create') {
        form.post(route('shipments.store'), {
            onBefore: () => NProgress.start(),
            onSuccess: () => close(),
            onFinish: (data) => NProgress.done()
        })
    }

    if (!props.shipment?.id) {
        form.setError('Id', 'Cant alter shipment, no id provided');
        return
    }

    if (props.shipment.method === 'update') {
        form.put(route('shipments.update', props.shipment.id), {
            onBefore: () => NProgress.start(),
            onSuccess: () => close(),
            onFinish: (data) => NProgress.done()
        })
    }

    if (props.shipment.method === 'delete') {
        form.delete(route('shipments.destroy', props.shipment.id), {
            preserveScroll: true,
            onBefore: () => NProgress.start(),
            onSuccess: () => close(),
            onFinish: (data) => NProgress.done()
        })
    }
}

function close() {
    form.reset()
    form.clearErrors()
    emit('close')
}

</script>

<template>

    <Modal :show="shipment != null" @close="close()">

        <form @submit.prevent="submit" class="p-3 space-y-0.5 bg-gray-800 text-white border border-gray-600 rounded-md">

            <div v-if="shipment.method === 'delete'" class="text-center">
                <div class="m-1">
                    Delete shipment with order id: {{ shipment.order_id.toUpperCase() }} ?
                </div>
            </div>

            <div v-if="shipment.method === 'create' || shipment.method === 'update'">
                <form-input
                    v-if="shipment.company"
                    label="Added by:"
                    type="text"
                    v-model="shipment.company.name"
                    disabled
                />

                <form-input
                    label="Load Number:"
                    type="text"
                    v-model="form.order_id"
                    :error="form.errors.order_id"
                />

                <form-input
                    label="Weight (lb):"
                    type="number"
                    v-model="form.weight"
                    :min="Number(0)"
                    :max="Number(50000)"
                    :error="form.errors.weight"
                />

                <form-input
                    label="Temperature (F):"
                    type="number"
                    v-model="form.temperature"
                    :min="Number(-50)"
                    :max="Number(100)"
                    :error="form.errors.temperature"
                />

                <form-input
                    label="Equipment Type:"
                    type="text"
                    v-model="form.equipment_type"
                    :error="form.errors.equipment_type"
                />

                <form-notes
                    label="Shipment notes:"
                    v-model="form.notes"
                    :error="form.errors.notes"
                />
            </div>

            <div class="flex justify-evenly">
                <main-button class="w-24" type="submit" :disabled="form.processing">
                    {{ capitalizeFirstLetter(shipment.method) }}
                </main-button>

                <main-button class="w-24" @click="emit('close')">
                    Discard
                </main-button>
            </div>

        </form>

    </Modal>

</template>
