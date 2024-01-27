<script setup>
defineProps({
  slots: Array,
  selected: String
})

defineEmits(['change'])

</script>

<template>
  <div class="grid grid-cols-3 border-t border-gray-600 divide-x text-center text-white bg-gray-800 ">
    <div v-for="slot in slots"
        class="p-2 cursor-pointer"
        :class="{'bg-gray-700': selected === slot}"
        @click="$emit('change', slot)"
    >
      {{ slot }}
    </div>
  </div>
</template>
