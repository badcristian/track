<script setup>
import {onBeforeMount, reactive, ref, watch} from "vue";
import debounce from "lodash/debounce.js";

import {parseAddress} from "@/helpers.js";
import {AutocompleteFactory} from "@/Pages/Shipment/Partials/Factories/AutocompleteFactory.js";
import NProgress from "nprogress";
import FormInput from "@/Pages/Shipment/Partials/Forms/Partials/FormInput.vue";

const props = defineProps({
    address: String,
})

const emit = defineEmits(['updated'])
const spinner = ref(false)
const addressToWatch = ref(props.address)

const predictions = reactive({
    show: true,
    items: []
})

let autocomplete

onBeforeMount(() => {
    AutocompleteFactory.init()
        .then((instance) => autocomplete = instance)
        .catch((e) => alert('AutocompleteFactory error:  ' + e.message))
})

watch(addressToWatch, debounce(function (address) {

        if (!autocomplete) return
        loading.start()

        autocomplete.getPredictions(address)
            .then((res) => predictions.items = res.predictions)
            .catch((e) => alert('getPredictions error:  ' + e.message))
            .finally(() => loading.done())
        predictions.show = true
    }, 300)
)

const getPredictionInfo = async (place_id) => {

    if (!autocomplete) return
    loading.start()

    autocomplete.getPredictionInfo(place_id)
        .then((res) => emit('updated', parseAddress(res.results[0])))
        .catch((e) => alert('getPredictionInfo error:  ' + e.message))
        .finally(() => loading.done())

    predictions.show = false
}

const loading = {
    start() {
        spinner.value = true
        NProgress.start()
    },
    done() {
        NProgress.done()
        spinner.value = false
    }
}

</script>

<template>
    <div class="relative">

        <FormInput
            label="Address:"
            type="text"
            v-model="addressToWatch"
            placeholder="search for a place..."
            :spinner="spinner"
        />

        <div v-show="predictions.show"
             class="z-50 absolute translate-y-1 w-full py-1">

            <div v-for="(item, index) in predictions.items.slice(0,4)"
                 class="bg-gray-600 hover:bg-gray-500 hover:cursor-pointer p-1 truncate ..."
                 :class="{
                    'rounded-t-md': index === 0,
                    'rounded-b-md': index === predictions.items.length-1 || index === 3
                }"
                 @click="getPredictionInfo(item.place_id)"
            >
                {{ item.description }}
            </div>

        </div>
    </div>
</template>
