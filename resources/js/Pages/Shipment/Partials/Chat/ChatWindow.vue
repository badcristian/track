<script setup>
import {computed, onMounted} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import NProgress from "nprogress";
import {rezizeTextArea, scrollToBottom} from "@/helpers.js";
import SvgSend from "@/Components/Icons/SvgSend.vue";
import ChatMessage from "@/Pages/Shipment/Partials/Chat/ChatMessage.vue";

const props = defineProps({
    comments: Array,
    shipmentId: Number
})

const currentUserId = computed(() => usePage().props.auth.user.id)

const form = useForm({
    body: '',
    user_id: currentUserId
})

function submit() {
    NProgress.start()
    form.post(route('comments.store', props.shipmentId), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('body')
            scrollToBottom('scrollBottom')
        },
        onFinish: (data) => NProgress.done()
    })
}

onMounted(() => {
    rezizeTextArea('resizeble')
    scrollToBottom('scrollBottom')
})

</script>

<template>

    <div class="h-full flex flex-col justify-between p-2 bg-gray-800 md:rounded-md">

        <div class="overflow-y-auto overflow-x-hidden flex-grow scrollbar" id="scrollBottom">

            <div v-if="!comments.length">
                No messages found
            </div>

            <ChatMessage
                v-for="message in comments"
                :message="message"
                :current_user_id="currentUserId"
            />
        </div>

        <div v-if="form.errors.body" class="text-red-600">
            {{ form.errors.body }}
        </div>

        <form @submit.prevent="submit" class="flex pt-2" :disabled="form.processing">
            <textarea
                id="resizeble"
                rows="1"
                class="resize-none block mx-3 w-full text-sm rounded-lg border bg-gray-800
                border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500
                overflow-y-hidden"
                v-model="form.body"
                @keydown.enter.exact.prevent="submit()"
                placeholder="Your message..."
                autofocus
            />
            <button type="submit" class="mr-3 text-blue-600 cursor-pointer dark:text-blue-500">
                <svg-send class="w-5 h-5 rotate-90" fill="white"/>
            </button>
        </form>

    </div>

</template>
