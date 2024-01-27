<script setup>
import MainButton from "@/Components/Buttons/MainButton.vue";
import { Link } from '@inertiajs/vue3';

defineProps({
    data: Object
})

</script>

<template>
    <div class="flex justify-center p-1 space-x-2">
        <Link :href="data.prev_page_url ?? 'null'" as="button" :disabled="!data.prev_page_url">
            <MainButton class="w-28" :disabled="!data.prev_page_url">
                Previous
            </MainButton>
        </Link>

        <Link :href="data.next_page_url ?? 'null'" as="button" :disabled="!data.next_page_url">
            <MainButton class="w-28" :disabled="!data.next_page_url">
                Next
            </MainButton>
        </Link>

    </div>
</template>

