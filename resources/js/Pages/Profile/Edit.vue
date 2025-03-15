<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head } from "@inertiajs/vue3";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profil" />

    <PosLayout title="Profil">
        <div class="mx-auto max-w-4xl px-4 py-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Profil</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Kelola informasi profil dan keamanan akun Anda.
                </p>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden rounded-lg bg-white p-6 shadow">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="overflow-hidden rounded-lg bg-white p-6 shadow">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="overflow-hidden rounded-lg bg-white p-6 shadow">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </PosLayout>
</template>
