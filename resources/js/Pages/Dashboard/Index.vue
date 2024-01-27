<script setup>
import Layout from "@/Layouts/Layout.vue";
import Panel from "@/Components/Panels/Panel.vue";
import PanelDivided from "@/Components/Panels/PanelDivided.vue";

</script>

<template>
    <Layout title="Dashboard">
        <div class="space-y-3 bg-gray-700 overflow-y-auto">
            <Panel>

                <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                    Welcome to your Jetstream application!
                </h1>

                Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel
                is designed
                to help you build your application using a development environment that is simple, powerful, and
                enjoyable. We believe
                you should love expressing your creativity through programming, so we have spent time carefully crafting
                the Laravel
                ecosystem to be a breath of fresh air. We hope you love it.
            </Panel>

            <PanelDivided>
                <template #top>aravel Jetstream provides a beautiful, robust starting point for your next Laravel
                    application. Laravel is designed
                    to help you build your application using a development environment that is simple, powerful, and
                    enjoyable. We believe
                    you should love expressing your
                </template>

                <template #bottom-column-one>aravel Jetstream provides a beautiful, robust starting point for your next
                    Laravel application. Laravel is designed
                    to help you build your application using a development environment that is simple, powerful, and
                    enjoyable. We believe
                    you should love expressing your
                </template>

                <template #bottom-column-two>aravel Jetstream provides a beautiful, robust starting point for your next
                    Laravel application. Laravel is designed
                    to help you build your application using a development environment that is simple, powerful, and
                    enjoyable. We believe
                    you should love expressing your
                </template>
            </PanelDivided>
        </div>
    </Layout>
</template>

<style scoped>

</style>
