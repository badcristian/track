<script setup>
import {computed, onMounted, onUnmounted, watch} from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    position: {
        type: String,
        default: 'default'
    },
    animation: {
        type: String,
        default: 'fade'
    },
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    emit('close');
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const positionClass = computed(() => {
    return {
        'default': 'mx-auto max-h-full py-2 w-96 max-w-[90%] md:min-w-[30rem]',
        'chat': 'mx-auto -md:max-h-[90%]  rounded-md border border-gray-600 shadow-xl',
        'left': 'h-full max-w-[16rem] shadow-xl',
    }[props.position];
});


</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto z-50 flex flex-col justify-center">

                <Transition name="fade">
                    <div v-show="show" class="fixed inset-0 transform transition-all " @click="close">
                        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-50 "/>
                    </div>
                </Transition>

                <Transition :name="animation">
                    <div v-show="show" class="transform transition-all " :class="[positionClass]">
                        <slot v-if="show"/>
                    </div>
                </Transition>

            </div>
        </Transition>
    </Teleport>

</template>

<style>

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-resize-enter-active {
    transition: all 0.3s ease-out;
}

.fade-resize-leave-active {
    transition: all 0.3s ease-in;
}

.fade-resize-enter-from,
.fade-resize-leave-to {
    opacity: 0;
    scale: 90%;
    transform: translateY(2rem);
}

.slide-from-left-enter-active,
.slide-from-left-leave-active {
    transition: all 0.1s linear;
}

.slide-from-left-enter-from,
.slide-from-left-leave-to {
    transform: translateX(-100%);
}

.slide-from-bottom-enter-active,
.slide-from-bottom-leave-active {
    transition: all 0.15s linear;
}

.slide-from-bottom-enter-from,
.slide-from-bottom-leave-to {
    transform: translateY(100%);
}

</style>
