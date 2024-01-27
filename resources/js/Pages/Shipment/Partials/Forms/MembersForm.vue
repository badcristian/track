<script setup>
import {useForm} from "@inertiajs/vue3";
import {reactive, ref, watch} from "vue";
import NProgress from "nprogress";
import debounce from "lodash/debounce.js";
import Modal from "@/Components/Modals/Modal.vue";
import SvgDeleteIcon from "@/Components/Icons/SvgDeleteIcon.vue";
import FormInput from "@/Pages/Shipment/Partials/Forms/Partials/FormInput.vue";
import SvgCloseIcon from "@/Components/Icons/SvgCloseIcon.vue";
import MainButton from "@/Components/Buttons/MainButton.vue";
import Member from "@/Pages/Shipment/Partials/Members/Member.vue";
import SearchResultMember from "@/Pages/Shipment/Partials/Forms/Partials/SearchResultMember.vue";


const emit = defineEmits(['close']);

const props = defineProps({
    members: Object
})

const form = useForm({members: []})
const spinner = ref(false)
const search = ref('')

const searchResult = reactive({
    members: [],
    empty: false
})

const addMemberToForm = (member) => {
    form.members.push(member);
    searchResult.members = searchResult.members.filter((item) => item.id !== member.id)
}

const removeMemberFromForm = (member) => {
    form.members = form.members.filter((item) => item.id !== member.id)
}

const addSearchResult = (members) => {

    if (!members.length) {
        searchResult.empty = true
        searchResult.members = []
        return
    }
    searchResult.empty = false
    let result = []
    members.forEach((item) => {
        if (memberExists(form.members, item)) {
            return
        }
        result.push(item)
    })
    searchResult.members = result.slice(0, 4)
    form.clearErrors()
}

const memberExists = (array, member) => {
    return array.find((item) => item.id == member.id)
}

watch(() => props.members, () => {
    form.reset()
    form.clearErrors()
    searchResult.members = []
    search.value = ''
})

watch(search, debounce(function (search) {

    if (search.replace(/\s+/g, '') == '' || !search) {
        searchResult.members = []
        searchResult.empty = false
        return
    }

    NProgress.start()
    spinner.value = true

    axios.get(route('members.search', props.members.shipment_id), {
        params: {role: props.role, search: search}
    })
        .then(({data}) => addSearchResult(data.users))
        .catch((err) => form.setError('Search', err.response.data.message))
        .finally(() => {
            NProgress.done()
            spinner.value = false
        })

}, 400))


function addMembersToShipment() {
    form.transform((data) => ({
        ...data,
        role: props.members.role ?? null,
    })).post(route('members.store', props.members.shipment_id), {
        preserveScroll: true,
        onBefore: () => NProgress.start(),
        onSuccess: () => emit('close'),
        onFinish: (data) => NProgress.done()
    })
}

function deleteFromShipment(member) {
    form.transform((data) => ({
        ...data,
        user_id: member.id
    })).delete(route('members.destroy', {shipment: props.members.shipment_id}), {
        onBefore: () => NProgress.start(),
        onSuccess: () => emit('close'),
        onFinish: (data) => NProgress.done()
    })
}

</script>

<template>

    <Modal :show="members != null" @close="$emit('close')">

        <form @submit.prevent="addMembersToShipment" class="text-white ">

            <div class="border border-gray-600 bg-gray-800 rounded-md p-3 space-y-2">

                <div v-for="currentMember in members.items" class="flex space-x-2">
                    <Member
                        :name="currentMember.name"
                        confirmed
                        class="border border-gray-600 flex-grow"
                    />
                    <SvgDeleteIcon
                        class="px-2 w-9 border border-gray-700 rounded-md
                                hover:bg-gray-600 hover:cursor-pointer"
                        @click="deleteFromShipment(currentMember)"
                    />
                </div>

                <div v-for="newMember in form.members" class="flex space-x-2">
                    <Member
                        :name="newMember.name"
                        in-progress
                        class="border border-gray-600 border-dashed flex-grow"
                    />
                    <SvgDeleteIcon
                        class="px-2 w-9 border border-gray-700 rounded-md
                               hover:bg-gray-600 hover:cursor-pointer"
                        @click="removeMemberFromForm(newMember)"
                    />
                </div>

                <div v-for="error in form.errors" class="text-red-500 text-sm">
                    {{ error }}
                </div>

                <div class="flex justify-between space-x-2">

                    <div class="w-full flex space-x-2">
                        <FormInput
                            class="flex-grow"
                            type="text"
                            :placeholder="`find a ${members.role}..`"
                            v-model="search"
                            :spinner="spinner || form.processing"
                        />
                        <SvgCloseIcon
                            class="px-2 w-9 border border-gray-700 rounded-md
                                   hover:bg-gray-600 hover:cursor-pointer"
                            @click="search = ''"
                        />
                    </div>
                </div>

                <div class="flex justify-between" v-if="form.members.length">
                    <MainButton class="w-32 border-green-400" type="submit" :disabled="form.processing">
                        Add Members
                    </MainButton>

                    <MainButton class="w-32" type="button">
                        Discard
                    </MainButton>
                </div>
            </div>

            <div class="rounded-md divide-y divide-gray-600 mt-2 bg-gray-700">
                <div v-if="searchResult.empty" class="p-1">
                    No results
                </div>
                <SearchResultMember
                    v-for="member in searchResult.members"
                    :member="member"
                    @click="addMemberToForm(member)"
                />
            </div>

        </form>

    </Modal>

</template>
