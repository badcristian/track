<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    email: String,
    phone: String
})

const form = useForm({
    name: '',
    email: props?.email ?? '',
    phone: '',
    company_id: ''
});

const submit = () => {
    form.post(route('register'), {
        // onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const numberToDisplay = ref('')

function filterNumber(value) {
    let x = value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
    form.phone = x[0]
    numberToDisplay.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
}

</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-900">

        <Head title="Register"/>

        <div class="text-white">
            You have to create an account
        </div>

        <form @submit.prevent="submit" class="w-[26rem] p-6 space-y-1">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="company" value="Company name"/>

                <TextInput
                    id="company"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company_id"
                    required
                    autocomplete="company"
                />

                <InputError class="mt-2" :message="form.errors.company_id"/>
            </div>

            <div >
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div >
                <InputLabel for="number" value="Phone number"/>

                <TextInput
                    id="number"
                    type="tel"
                    placeholder="(123) 123-1234"
                    class="mt-1 block w-full"
                    v-model="numberToDisplay"
                    @input="(e)=> filterNumber(e.target.value)"
                    required
                />

                <InputError class="mt-2" :message="form.errors.phone"/>
            </div>

            <div class="flex items-center justify-between pt-1">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>

    </div>
</template>
