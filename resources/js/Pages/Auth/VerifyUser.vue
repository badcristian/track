<script setup>
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import InputError from '@/Components/Inputs/InputError.vue';
import InputLabel from '@/Components/Inputs/InputLabel.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import CodeInput from "@/Components/Inputs/CodeInput.vue";
import {onMounted, onUnmounted, ref} from "vue";

const props = defineProps({
    status: String,
    email: String,
});

const form = useForm({
    remember: false,
    code: ''
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        email: props.email
    })).post(route('verify.user'), {
        onFinish: () => form.reset('code'),
    });
};

const filter = () => {
    form.code = form.code.replace(/[^0-9]/g, "");
}

const countDown = ref(60)

function countDownTimer() {
    if (countDown.value > 0) {
        setTimeout(() => {
            countDown.value -= 1
            countDownTimer()
        }, 1000)
    }
}

countDownTimer()

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

</script>

<template>

    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
            </Link>
        </div>

        <div class="w-[26rem] p-6">
            <Head title="Log in"/>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-3 pb-20">
                <div>
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full disabled:bg-slate-800 disabled:text-slate-400"
                        :model-value="email"
                        disabled
                    />
                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>


                <div class="mt-4">
                    <InputLabel for="code" value="Please provide your 4 digit code."/>

                    <CodeInput v-model="form.code"/>

                    <InputError class="mt-2" :message="form.errors.code"/>
                </div>

                <div class="mt-4 flex items-center justify-between">

                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember"/>
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>

                    <Link
                        :href="route('login')"
                        method="post"
                        :data="{ email: email }"
                        :class="{
                            'pointer-events-none': countDown > 0,
                            'underline': !countDown
                        }"
                        class="text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2
                               focus:ring-indigo-500 focus:ring-offset-gray-800"
                    >
                        Resend code (in {{ countDown }} seconds)
                    </Link>
                </div>


                <button
                    class="w-full text-center px-4 py-2 bg-gray-600 border border-transparent
                           font-semibold text-xs uppercase tracking-widest
                           rounded-md text-white hover:text-black hover:bg-gray-200
                           focus:bg-gray-700 dark:focus:bg-white focus:outline-none
                           transition ease-in-out duration-150"

                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Login
                </button>
            </form>
        </div>
    </div>
</template>
