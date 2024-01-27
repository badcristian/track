<script setup>
import Modal from "@/Components/Modals/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import NProgress from "nprogress";
import {watch} from "vue";
import {useStopTime} from "@/Pages/Shipment/Partials/Composables/UseStopTime.js";
import MainButton from "@/Components/Buttons/MainButton.vue";
import {capitalizeFirstLetter} from "@/helpers.js";
import StopType from "@/Pages/Shipment/Partials/Forms/Partials/StopType.vue";
import ApptType from "@/Pages/Shipment/Partials/Forms/Partials/ApptType.vue";
import FormInput from "@/Pages/Shipment/Partials/Forms/Partials/FormInput.vue";
import FormInputError from "@/Pages/Shipment/Partials/Forms/Partials/FormInputError.vue";
import FormNotes from "@/Pages/Shipment/Partials/Forms/Partials/FormNotes.vue";
import AddressAutocomplete from "@/Pages/Shipment/Partials/Forms/Partials/AddressAutocomplete.vue";

const emit = defineEmits(['close']);

const props = defineProps({
    stop: Object
})

const form = useForm({})

watch(() => props.stop, (stop) => {
    form.defaults({
        shipment_id: stop?.shipment_id ?? null,
        type: stop?.type ?? 'pickup',
        name: stop?.name ?? '',
        status: stop?.status ?? '',
        datetime: stop?.datetime ?? null,
        arrival_datetime: stop?.arrival_datetime ?? null,
        departure_datetime: stop?.departure_datetime ?? null,
        fcfs: stop?.fcfs ?? 0,
        working_hours_start: stop?.working_hours_start ?? null,
        working_hours_end: stop?.working_hours_end ?? null,
        ref_numbers: stop?.ref_numbers ?? '',
        street_address: stop?.street_address ?? '',
        city: stop?.city ?? '',
        state: stop?.state ?? '',
        country: stop?.country ?? '',
        zip_code: stop?.zip_code ?? '',
        lat: stop?.lat ?? '',
        lng: stop?.lng ?? '',
        notes: stop?.notes ?? '',
    }).reset()
})

const {date, time, hoursStart, hoursEnd} = useStopTime(() => props.stop)

function submit() {

    if (props.stop.method === 'delete') {
        form.delete(route('stops.destroy', [props.stop.shipment_id, props.stop.id]), {
            preserveScroll: true,
            onBefore: () => NProgress.start(),
            onSuccess: () => emit('close'),
            onFinish: (data) => NProgress.done()
        })

        return
    }

    if (!form.isDirty) {
        form.setError('changed', 'No changes were made to this stop');
        return
    }

    form.datetime = `${date.value} ${time.value}`
    form.working_hours_start = `${date.value} ${hoursStart.value}`
    form.working_hours_end = `${date.value} ${hoursEnd.value}`

    if (props.stop.method === 'create') {
        form.post(route('stops.store', props.stop.shipment_id), {
            preserveScroll: true,
            onBefore: () => NProgress.start(),
            onSuccess: () => close(),
            onFinish: (data) => NProgress.done()
        })
    }

    if (props.stop.method === 'update') {
        form.put(route('stops.update', [props.stop.shipment_id, props.stop.id]), {
            preserveScroll: true,
            onBefore: () => NProgress.start(),
            onSuccess: () => close(),
            onFinish: (data) => NProgress.done()
        })
    }
}

function updateAddress(address) {
    for (const key of Object.keys(address)) {
        if (key in form) {
            form[key] = address[key];
        }
    }
}

function close() {
    form.reset()
    form.clearErrors()
    emit('close')
}

</script>

<template>
    <modal :show="stop != null" @close="close()">

        <form @submit.prevent="submit()" class="p-3 space-y-1 bg-gray-800 text-white border border-gray-600 rounded-md">

            <div v-if="stop.method === 'delete'" class="text-center">
                <div>Delete stop:</div>
                <div class="mt-2">Facility name: {{ stop?.name ?? '' }}</div>
                {{ stop.street_address + ', ' + stop.city + ', ' + stop.state + ' ??' }}
            </div>

            <div v-if="stop.method === 'create' || stop.method === 'update'">
                STOP AND APPT TYPES:
                <div class="space-y-2">
                    <StopType v-model="form.type"/>
                    <ApptType v-model="form.fcfs"/>
                </div>

                <FormInputError :message="form.errors.type"/>
                <FormInputError :message="form.errors.fcfs"/>

                <div v-if="!form.fcfs" class="grid grid-cols-2 gap-2">
                    <FormInput :label="form.type.toUpperCase() + ' DATE'" type="date" v-model="date"/>
                    <FormInput label="APPT TIME:" type="time" v-model="time"/>
                </div>

                <div v-if="form.fcfs" class="grid grid-cols-3 gap-2 ">
                    <FormInput label="DATE:" type="date" v-model="date"/>
                    <FormInput label="HOURS START:" type="time" v-model="hoursStart"/>
                    <FormInput label="HOURS END:" type="time" v-model="hoursEnd"/>
                </div>

                <FormInputError :message="form.errors.datetime"/>
                <FormInputError :message="form.errors.working_hours_start"/>
                <FormInputError :message="form.errors.working_hours_end"/>

                <FormInput label="Ref#:" type="text" v-model="form.ref_numbers" :error="form.errors.ref_numbers"/>
                <FormInput label="Facility name:" type="text" v-model="form.name" :error="form.errors.name"/>

                <AddressAutocomplete :address="form.street_address"
                                      @updated="(newFullAddrs)=>updateAddress(newFullAddrs)"/>
                <FormInputError :message="form.errors.street_address"/>

                <FormInput label="City:" type="text" v-model="form.city" :error="form.errors.city"/>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <FormInput
                            label="State:"
                            type="text"
                            v-model="form.state"
                            :error="form.errors.state"/>
                    </div>

                    <div>
                        <FormInput
                            label="Zip Code:"
                            v-model="form.zip_code"
                            type="text"
                            :error="form.errors.zip_code"/>
                    </div>
                </div>

                <FormNotes v-model="form.notes" :error="form.errors.notes"/>
                <FormInputError :message="form.errors.changed"/>
            </div>

            <div class="flex justify-evenly">
                <main-button class="w-24" type="submit" :disabled="form.processing">
                    {{ capitalizeFirstLetter(stop.method) }}
                </main-button>
                <main-button class="w-24" @click="close()">
                    Discard
                </main-button>
            </div>
        </form>

    </modal>
</template>
