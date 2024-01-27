<script setup>
import {ref} from "vue";
import SvgTruck from "@/Components/Icons/SvgTruck.vue";
import SvgStats from "@/Components/Icons/SvgStats.vue";
import ApplicationMark from "@/Components/Icons/ApplicationMark.vue";
import SvgBell from "@/Components/Icons/SvgBell.vue";
import SvgArrowOpenPanel from "@/Components/Icons/SvgArrowOpenPanel.vue";
import SvgThemeIcon from "@/Components/Icons/SvgThemeIcon.vue";
import SvgAccount from "@/Components/Icons/SvgAccount.vue";
import SvgOrganization from "@/Components/Icons/SvgOrganization.vue";
import NavigationButton from "@/Components/Buttons/NavigationButton.vue";
const open = ref(false)

const toggle = () => {
    open.value = !open.value
}

</script>

<template>
    <div class="bg-gray-800 h-full border-r border-gray-600">
        <div class="h-full flex flex-col justify-between pt-6 pb-3">

            <div class="space-y-2">

                <div class="flex justify-between">
                    <NavigationButton :href="route('shipments.index')" disable-tooltip>
                        <application-mark/>
                    </NavigationButton>

                    <NavigationButton
                        :hidden="!open"
                        :href="route('shipments.index')"
                        disable-tooltip
                    >
                        <svg-bell/>
                    </NavigationButton>
                </div>

                <!-- LINKS-->
                <NavigationButton
                    :href="route('dashboard.index')"
                    text="DASHBOARD"
                    :show-text="open"
                    :active="true"
                >
                    <svg-organization/>
                </NavigationButton>

                <NavigationButton
                    :href="route('shipments.index')"
                    text="MY SHIPMENTS"
                    :show-text="open"
                    :active="true"
                >
                    <svg-truck/>
                </NavigationButton>

                <NavigationButton :href="route('shipments.index')" text="STATS" :show-text="open">
                    <svg-stats/>
                </NavigationButton>

                <NavigationButton
                    v-show="!open"
                    :href="route('shipments.index')"
                    text="NOTIFICATIONS"
                    :show-text="open"
                >
                    <svg-bell/>
                </NavigationButton>

            </div>

            <div class="space-y-2">
                <NavigationButton :href="route('profile.edit')" text="JOHN DOE" :show-text="open">
                    <svg-account/>
                </NavigationButton>

                <NavigationButton text="THEME" :show-text="open">
                    <svg-theme-icon/>
                </NavigationButton>

                <NavigationButton
                    :text="(open ? 'MINIMIZE' : 'MAXIMIZE') + ' SIDEBAR'"
                    :show-text="open"
                    @click="toggle"
                >
                    <svg-arrow-open-panel :class="{'transform rotate-180':  open}"/>
                </NavigationButton>
            </div>

        </div>
    </div>

</template>
