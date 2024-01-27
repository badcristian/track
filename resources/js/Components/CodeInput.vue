<script setup>
import {ref} from "vue";

defineProps({
    modelValue: String
})

const emit = defineEmits(['update:modelValue']);
const list = ref([0, 1, 2, 3])
const itemRefs = ref([])

function emitUpdate() {
    let array = []
    itemRefs.value.forEach((item) => array.push(item.value))
    emit('update:modelValue', array.join(''))
}

function filter(value) {
    return value.replace(/[^0-9]/g, "")
}

function moveLeft(i) {
    if (i > 0) {
        itemRefs.value[i - 1].focus()
    }
}

function moveRight(i) {
    if (i < 3) {
        itemRefs.value[i + 1].focus()
    }
}

function paste(event) {
    const filtered = filter(event.clipboardData.getData('text'))
    itemRefs.value.forEach((input, index) => {
        console.log(filtered[index])
        input.value = filtered[index] ?? ''
    })
}

function onInput(event, index) {
    const filtered = filter(event.target.value)
    event.target.value = filtered
    if (filtered) {
        moveRight(index)
    }
    emitUpdate()
}

</script>

<template>
    <div class="flex justify-center mt-4 space-x-3 [&>*]:w-10 [&>*]:text-center">
        <input
            class="border-gray-700 bg-gray-900 focus:border-indigo-700 focus:ring-indigo-700 rounded-md text-white"
            required
            type="text"
            maxlength="1"
            v-for="i in list"
            ref="itemRefs"
            :value="modelValue[i] ?? ''"
            :autofocus="i === 0"
            @keydown.delete="(e)=> {!e.target.value && moveLeft(i); e.target.value = ''} "
            @keydown.left="moveLeft(i)"
            @keydown.right="moveRight(i)"
            @paste="(e)=>paste(e)"
            @input="(e) => onInput(e, i)"
        />
    </div>
</template>
