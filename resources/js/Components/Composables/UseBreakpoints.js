import {computed, onMounted, onUnmounted, ref} from "vue";

export function useBreakpoints() {

    const windowWidth = ref(window.innerWidth)

    const onWidthChange = () => windowWidth.value = window.innerWidth

    onMounted(() => window.addEventListener('resize', onWidthChange))
    onUnmounted(() => window.removeEventListener('resize', onWidthChange))

    const mobile = computed(() => {
        return (windowWidth.value < 768)
    })

    const desktop = computed(() => {
        return (windowWidth.value >= 768)
    })

    return {mobile, desktop}
}
