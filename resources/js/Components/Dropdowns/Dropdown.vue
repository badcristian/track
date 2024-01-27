<script setup>
import {onMounted, onUnmounted, ref} from 'vue';

const props = defineProps({
    preventCloseOnClick: {
        type: Boolean,
        default: false
    }
});

const show = ref(false);

const closeOnEscape = (e) => {
    if (show.value && e.key === 'Escape') {
        show.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));


function toggleOpen() {
    if (!props.preventCloseOnClick) {
        show.value = false
    }
}

</script>

<template>
    <div class="relative">

        <div @click="show = !show">
            <slot name="trigger"/>
        </div>

        <div v-show="show" class="fixed inset-0 z-40 -md:backdrop-blur-sm" @click="show = false"/>

        <transition name="dropdown">
            <div v-show="show"
                 class="-md:dropdown-mobile md:dropdown-desktop"
                 style="display: none;"
                 @click="toggleOpen()"
            >
                <slot name="content"/>
            </div>
        </transition>

    </div>
</template>


<style>

@media (max-width: 767px) {
    .dropdown-enter-active,
    .dropdown-leave-active {
        transition: all 0.2s ease;
    }

    .dropdown-enter-from,
    .dropdown-leave-to {
        transform: translateY(100%);
    }
}

@media (min-width: 768px) {
    .dropdown-enter-active,
    .dropdown-leave-active {
        transition: all 0.3s ease;
    }

    .dropdown-enter-from,
    .dropdown-leave-to {
        opacity: 0;
        scale: 95%;
    }
}
</style>
