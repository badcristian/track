import {ref, toValue, watchEffect} from "vue";

export function useStopTime(selectedStop) {

    const date = ref()
    const time = ref()
    const hoursStart = ref()
    const hoursEnd = ref()

    watchEffect(() => {
        let stop = toValue(selectedStop)

        date.value = stop?.datetime?.slice(0, 10) ?? '2011-11-11'
        time.value = stop?.datetime?.slice(11, 16) ?? '07:00'
        hoursStart.value = stop?.working_hours_start?.slice(11, 16) ?? '08:00'
        hoursEnd.value = stop?.working_hours_end?.slice(11, 16) ?? '18:00'
    })

    // expose managed state as return value
    return {date, time, hoursStart, hoursEnd}
}

