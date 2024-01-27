<script setup>
import SvgStats from "@/Components/Icons/SvgStats.vue";
import NavigationButton from "@/Components/Buttons/NavigationButton.vue";
import SvgTruck from "@/Components/Icons/SvgTruck.vue";
import SvgAccount from "@/Components/Icons/SvgAccount.vue";
import SvgBell from "@/Components/Icons/SvgBell.vue";
import SvgThemeIcon from "@/Components/Icons/SvgThemeIcon.vue";
import ApplicationMark from "@/Components/Icons/ApplicationMark.vue";
import Modal from "@/Components/Modals/Modal.vue";
import SvgOrganization from "@/Components/Icons/SvgOrganization.vue";

defineProps({
  show: Boolean
})

defineEmits(['close']);


</script>

<template>

  <div class="absolute" >

    <Modal :show="show" @close="$emit('close')" position="left" animation="slide-from-left">

      <div class="bg-gray-800 h-full border-r border-gray-600">

        <div class="h-full flex flex-col justify-between pt-6 pb-3">

          <div class="space-y-2">

            <div class="flex justify-between">
              <NavigationButton :href="route('shipments.index')" disable-tooltip>
                <application-mark/>
              </NavigationButton>
            </div>

            <!-- LINKS-->
              <NavigationButton
                  :href="route('dashboards.index')"
                  text="DASHBOARD"
                  :show-text="true"
                  :active="true"
              >
                  <svg-organization/>
              </NavigationButton>

            <NavigationButton
                :href="route('shipments.index')"
                text="MY SHIPMENTS"
                :show-text="true"
                :active="true"
            >
              <svg-truck/>
            </NavigationButton>

            <NavigationButton :href="route('shipments.index')" text="STATS" :show-text="true">
              <svg-stats/>
            </NavigationButton>

            <NavigationButton
                :href="route('shipments.index')"
                text="NOTIFICATIONS"
                :show-text="true"
            >
              <svg-bell/>
            </NavigationButton>

          </div>

          <div class="space-y-2">
            <NavigationButton :href="route('profile.edit')" text="JOHN DOE" :show-text="true">
              <svg-account/>
            </NavigationButton>

            <NavigationButton text="THEME" :show-text="true">
              <svg-theme-icon/>
            </NavigationButton>
          </div>

        </div>
      </div>
    </Modal>
  </div>
</template>

