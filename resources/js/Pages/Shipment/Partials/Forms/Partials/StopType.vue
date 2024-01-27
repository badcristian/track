<script setup>
import {onBeforeMount} from "vue";

const props = defineProps({
  modelValue: String,
  title: String
})

const emit = defineEmits(['update:modelValue']);

onBeforeMount(() => {
  if (props.modelValue !== 'pickup' && props.modelValue !== 'delivery') {
    emit('update:modelValue', 'pickup')
  }
})

</script>

<template>

  <div class="flex w-full space-x-2">

    <div class="border border-gray-600 rounded-md p-2 hover:bg-gray-600 w-full whitespace-nowrap flex justify-center"
         :class="[modelValue === 'pickup' ? 'bg-gray-700' : 'bg-slate-900']"
         @click="$emit('update:modelValue', 'pickup')"
    >

      <div class="rounded-md cursor-pointer mx-1">
        PICKUP
        <span :class="{'opacity-0': modelValue === 'delivery'}" class="text-green-500">✓</span>
      </div>

    </div>

    <div class="border border-gray-600 rounded-md p-2 hover:bg-gray-700 w-full whitespace-nowrap flex justify-center"
         :class="[modelValue === 'delivery' ? 'bg-gray-700' : 'bg-slate-900']"
         @click="$emit('update:modelValue', 'delivery')"
    >

      <div class="rounded-md cursor-pointer mx-1">
        DELIVERY <span :class="{'opacity-0': modelValue === 'pickup'}" class="text-green-500 ">✓</span>
      </div>

    </div>
  </div>

</template>
