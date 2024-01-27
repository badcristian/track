<script setup>
import {reactive, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import {setTrueOrDelete, deleteProperties} from "@/helpers.js";
import SvgSmallArrow from "@/Components/Icons/SvgSmallArrow.vue";
import SearchTextInput from "@/Pages/Shipment/Partials/Inputs/SearchTextInput.vue";
import SvgOptionsIcon from "@/Components/Icons/SvgOptionsIcon.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import DropdownButton from "@/Components/Buttons/DropdownButton.vue";

const props = defineProps({
    propsFilters: Object
})

const filters = reactive({...props.propsFilters})

const showFilters = ref(false)

watch(filters, debounce(function (filters) {
    router.get('/shipments', filters, {preserveState: true, replace: true})
}, 400))

</script>

<template>
    <div class="md:text-lg p-2 md:px-4">

        <div class="flex space-x-2">

            <search-text-input
                id="search"
                v-model="filters.search"
                type="text"
                autocomplete="search"
                placeholder="Search.."
                autofocus
                class="w-full"
            />

            <main-button class=" md:hidden" @click="showFilters = !showFilters">
                <svg-options-icon class="h-6"/>
            </main-button>

        </div>

        <div class="[&>*]:mt-2 space-x-2 space-x-reverse" :class="[showFilters ? 'flex flex-wrap' : 'hidden md:flex']">

            <main-button
                class="order-1 sm:ml-auto whitespace-nowrap"
                @click="deleteProperties(filters)"
            >
                Clear All
            </main-button>

            <main-button
                :class="{'main-active-bg': Boolean(filters.active ?? false)}"
                @click="setTrueOrDelete(filters, 'active')"
            >
                Active
            </main-button>

            <main-button
                :class="{'main-active-bg': Boolean(filters.closed ?? false)}"
                @click="setTrueOrDelete(filters, 'closed')"
            >
                Closed
            </main-button>


            <dropdown>
                <template #trigger>
                    <main-button class="flex items-center">
                        <svg-small-arrow class="h-[1rem] mr-1"/>
                        Status
                    </main-button>
                </template>

                <template #content>
                    <dropdown-button>
                        asd
                    </dropdown-button>
                </template>
            </dropdown>

        </div>
    </div>
</template>

