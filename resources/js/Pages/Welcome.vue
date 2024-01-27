<script setup>
import { Head, Link } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Welcome" />
    <Link :href="route('logout')" method="post" as="button" class="border border-gray-500">
        Logut
    </Link>
</template>

