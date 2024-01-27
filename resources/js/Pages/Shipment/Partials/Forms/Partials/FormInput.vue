<script setup>
import {computed, ref} from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    type: String,
    id: String,
    placeholder: String,
    error: String,
    min: Number,
    max: Number,
    disabled: Boolean,
    spinner: Boolean
});

defineEmits(['update:modelValue', 'onFocus', 'onFocusOut', 'onFocusIn']);

const isDateTime = computed(() => {
    return props.type === 'date' || props.type === 'time'
})

function togglePicker(event) {
    try {
        isDateTime && event.target.showPicker()
    } catch (err) {
    }
}


const input = ref(null);

</script>

<template>
    <div>

        <label for="" class="truncate">
            {{ label }}
        </label>

        <div class="relative">
            <input
                :type="type"
                class="border-gray-600 bg-gray-900 text-gray-300 focus:border-blue-500
                focus:ring-gray-600 rounded-md shadow-sm w-full disabled:opacity-60"
                :class="{'cursor-pointer': isDateTime, 'border-red-500 ': error}"
                :value="modelValue"
                :placeholder="placeholder"
                @input="$emit('update:modelValue', $event.target.value)"
                @click="togglePicker($event)"
                :id="id"
                @focus="$emit('onFocus')"
                @focusout="$emit('onFocusOut')"
                @focusin="$emit('onFocusIn')"
                :min="min"
                :max="max"
                :disabled="disabled"
            >

            <div v-if="spinner" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                <div class="spinner-icon"/>
            </div>
        </div>


        <div class="text-red-500" v-show="error">{{ error }}</div>
    </div>

</template>

<style scoped>
input[type="time"]::-webkit-calendar-picker-indicator, input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
}

input[type="time"]::-webkit-calendar-picker-indicator:hover, input[type="date"]::-webkit-calendar-picker-indicator:hover {
    cursor: pointer;
}
</style>
