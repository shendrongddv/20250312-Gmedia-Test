<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="text-center md:text-start">
            <h2 class="text-2xl font-bold text-gray-900">
                Selamat Datang di MASPOS
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Masuk untuk mengelola bisnis Anda dengan mudah dan efisien.
            </p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="mt-8 space-y-6">
            <div>
                <InputLabel for="email" value="Username" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <div>
                <button
                    :disabled="form.processing"
                    class="flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Masuk
                </button>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                Belum punya akun?
                <Link
                    :href="route('register')"
                    class="ml-1 font-medium text-blue-600 hover:text-blue-500"
                >
                    Daftar sekarang
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
