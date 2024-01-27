<script setup>
import InputError from '@/Components/Inputs/InputError.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";

const props = defineProps({
    status: String
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('login'), {
        preserveState: true,
        // onFinish: () => form.reset('password'),
    });
};

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
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        placeholder="Email address or a phone number"
                    />
                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>

                <button
                    class="w-full text-center px-4 py-2 bg-gray-600 border border-transparent
                           font-semibold text-xs uppercase tracking-widest
                           rounded-md text-white hover:text-black hover:bg-gray-200
                           focus:bg-gray-700 dark:focus:bg-white focus:outline-none
                           transition ease-in-out duration-150"

                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Continue
                </button>
            </form>
        </div>
    </div>

</template>
