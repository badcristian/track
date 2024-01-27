<script setup>
import {formatTime} from "@/helpers.js";
defineProps({
    message: Object,
    current_user_id: Number
})
</script>

<template>
    <div class="p-2 bg-gray-700 main-rounded w-[80%] mb-2 mx-1"
         :class="{'float-right': message.user.id === current_user_id}"
    >

        <div class="text-blue-200 text-xs">
            {{ message.user.id === current_user_id ? 'Me' : message.user.name }}
        </div>

        <div class="text-gray-200">
            {{ message.body }}
        </div>

        <div class="text-blue-200 text-xs text-right">
            {{ formatTime(message.created_at) }}
        </div>
    </div>
</template>
