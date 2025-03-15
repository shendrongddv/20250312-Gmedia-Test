<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    is_active: true,
});

const submit = () => {
    form.post(route("categories.store"));
};
</script>

<template>
    <Head title="Tambah Kategori" />

    <PosLayout>
        <div class="mx-auto max-w-lg">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <h1 class="mb-6 text-xl font-bold text-gray-900">
                        Tambah Kategori
                    </h1>

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label
                                for="name"
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Kategori</label
                            >
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                placeholder="Kategori"
                                required
                            />
                            <div
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                for="description"
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Deskripsi (Opsional)</label
                            >
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="3"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                placeholder="Deskripsi kategori"
                            ></textarea>
                            <div
                                v-if="form.errors.description"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                />
                                <label
                                    for="is_active"
                                    class="ml-2 block text-sm text-gray-700"
                                    >Aktif</label
                                >
                            </div>
                            <div
                                v-if="form.errors.is_active"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.is_active }}
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <Link
                                :href="route('categories.index')"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                :class="{
                                    'cursor-not-allowed opacity-75':
                                        form.processing,
                                }"
                            >
                                <svg
                                    v-if="form.processing"
                                    class="-ml-1 mr-2 h-4 w-4 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PosLayout>
</template>
