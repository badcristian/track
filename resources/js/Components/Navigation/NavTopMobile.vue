<script setup>
import SvgBell from "@/Components/Icons/SvgBell.vue";
import SvgHamburger from "@/Components/Icons/SvgHamburger.vue";
import SvgAccount from "@/Components/Icons/SvgAccount.vue";

defineProps({
  modelValue: Boolean,
});

defineEmits(['update:modelValue']);

</script>

<template>
  <div class="grid grid-cols-3 place-items-center bg-gray-800 border-b border-gray-600 p-1.5">

    <div class="w-full cursor-pointer"
         @click="$emit('update:modelValue', !modelValue)"
         :class="{'bg-gray-700': modelValue}"
    >
      <svg-hamburger class="h-7 mx-auto " />
    </div>

    <div class="w-full cursor-pointer ">
      <svg-bell class="h-7 mx-auto" />
    </div>

    <div class="w-full cursor-pointer">
      <svg-account class="h-7 mx-auto" />
    </div>
  </div>
</template>
