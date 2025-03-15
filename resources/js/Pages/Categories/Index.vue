<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    categories: Object,
    message: String,
});

const deleteCategory = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
        router.delete(route("categories.destroy", id));
    }
};

const searchQuery = ref("");
const filteredCategories = computed(() => {
    if (!searchQuery.value) return props.categories.data;

    return props.categories.data.filter((category) =>
        category.name.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});
</script>

<template>
    <Head title="Kategori" />

    <PosLayout>
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="text-2xl font-bold text-gray-900">Kategori</h1>
            <Link
                :href="route('categories.create')"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd"
                    />
                </svg>
                Tambah Kategori
            </Link>
        </div>

        <!-- Success Message -->
        <div
            v-if="message"
            class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700"
        >
            <div class="flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                {{ message }}
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="mb-6">
            <div class="relative">
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <input
                    type="text"
                    v-model="searchQuery"
                    placeholder="Cari kategori..."
                    class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
            </div>
        </div>

        <!-- Categories Table -->
        <div
            class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
        >
            <div
                v-if="categories.data.length === 0"
                class="flex flex-col items-center justify-center py-12"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mb-4 h-16 w-16 text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                    />
                </svg>
                <p class="mb-2 text-lg font-medium text-gray-900">
                    Belum ada kategori
                </p>
                <p class="mb-6 text-sm text-gray-500">
                    Silakan tambahkan kategori baru untuk produk Anda
                </p>
                <Link
                    :href="route('categories.create')"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Tambah Kategori
                </Link>
            </div>

            <div v-else>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                Nama
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                Slug
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                Status
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr
                            v-for="category in filteredCategories"
                            :key="category.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ category.name }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    {{ category.slug }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    :class="[
                                        'inline-flex rounded-full px-2 text-xs font-semibold leading-5',
                                        category.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{
                                        category.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium"
                            >
                                <Link
                                    :href="
                                        route('categories.edit', category.id)
                                    "
                                    class="mr-3 text-blue-600 hover:text-blue-900"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="deleteCategory(category.id)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div
                    class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                >
                    <div
                        class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{
                                    categories.from
                                }}</span>
                                sampai
                                <span class="font-medium">{{
                                    categories.to
                                }}</span>
                                dari
                                <span class="font-medium">{{
                                    categories.total
                                }}</span>
                                hasil
                            </p>
                        </div>
                        <div>
                            <nav
                                class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                                aria-label="Pagination"
                            >
                                <Link
                                    v-for="(link, i) in categories.links"
                                    :key="i"
                                    :href="link.url"
                                    v-html="link.label"
                                    class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                                    :class="{
                                        'z-10 border-blue-500 bg-blue-50 text-blue-600':
                                            link.active,
                                        'cursor-not-allowed opacity-50':
                                            !link.url,
                                        'rounded-l-md': i === 0,
                                        'rounded-r-md':
                                            i === categories.links.length - 1,
                                    }"
                                />
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PosLayout>
</template>
