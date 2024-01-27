<script setup>
import {computed} from "vue";

const props = defineProps({
  name: String,
  newMember: Boolean
})

const initials = computed(() => {
  let init = ''
  props.name.split(' ').forEach((el, index) => index <=1 ? init += el[0] : null)
  return init
})

const randomColor = computed(()=>{
  const colors = ['bg-slate-800', 'bg-slate-700', 'bg-slate-600', 'bg-gray-800', 'bg-gray-700', 'bg-gray-600'];
  const nb = Math.floor(Math.random() * colors.length)
  return colors[nb]
})

</script>

<template>


 <div>
   <div v-if="!newMember"
        class="rounded-3xl border border-gray-500 w-7 h-7 flex justify-center items-center truncate
               hover:cursor-pointer text-sm"
        :class="randomColor"
   >
     {{ initials }}
   </div>

   <div v-if="newMember" class="rounded-3xl border border-gray-500 border-dashed w-7 h-7 flex justify-center items-center truncate
               hover:cursor-pointer text-sm"
        >
     +
   </div>
 </div>

</template>

<style scoped>

</style>
