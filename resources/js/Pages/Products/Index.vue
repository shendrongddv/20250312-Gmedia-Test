<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";
import { ref, computed } from "vue";

const props = defineProps({
    products: Object,
    message: String,
});

const deleteProduct = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
        router.delete(route("products.destroy", id));
    }
};

// Search functionality
const searchQuery = ref("");
const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products.data;

    const query = searchQuery.value.toLowerCase();
    return props.products.data.filter(
        (product) =>
            product.name.toLowerCase().includes(query) ||
            product.category?.name.toLowerCase().includes(query),
    );
});
</script>

<template>
    <Head title="Produk" />

    <PosLayout>
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Produk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola semua produk yang tersedia di toko Anda
                </p>
            </div>
            <Link
                :href="route('products.create')"
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
                Tambah Produk
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
                        class="h-5 w-5 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <input
                    v-model="searchQuery"
                    type="text"
                    class="block w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Cari produk..."
                />
            </div>
        </div>

        <!-- Products List -->
        <div
            class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
        >
            <div
                v-if="filteredProducts.length === 0"
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
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    />
                </svg>
                <p class="mb-2 text-lg font-medium text-gray-900">
                    Tidak ada produk
                </p>
                <p class="mb-6 text-sm text-gray-500">
                    Produk yang Anda tambahkan akan muncul di sini
                </p>
                <Link
                    :href="route('products.create')"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                >
                    Tambah Produk
                </Link>
            </div>

            <div v-else>
                <!-- Desktop Table -->
                <div class="hidden md:block">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Produk
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Kategori
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Harga
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Stok
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
                                v-for="product in filteredProducts"
                                :key="product.id"
                                class="hover:bg-gray-50"
                            >
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img
                                                :src="product.image_url"
                                                class="h-10 w-10 rounded-full object-cover"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{ product.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-500">
                                        {{
                                            product.category?.name ||
                                            "Tidak ada kategori"
                                        }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        Rp {{ formatPrice(product.price) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ product.stock }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                        :class="[
                                            product.is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            product.is_active
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
                                            route('products.edit', product.id)
                                        "
                                        class="mr-3 text-blue-600 hover:text-blue-900"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        @click="deleteProduct(product.id)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile List -->
                <div class="divide-y divide-gray-200 md:hidden">
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        class="p-4 hover:bg-gray-50"
                    >
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img
                                    :src="product.image_url"
                                    class="h-10 w-10 rounded-full object-cover"
                                />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm font-medium text-gray-900"
                                >
                                    {{ product.name }}
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    {{
                                        product.category?.name ||
                                        "Tidak ada kategori"
                                    }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    Rp {{ formatPrice(product.price) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Stok: {{ product.stock }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-between">
                            <span
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                :class="[
                                    product.is_active
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800',
                                ]"
                            >
                                {{
                                    product.is_active ? "Aktif" : "Tidak Aktif"
                                }}
                            </span>
                            <div>
                                <Link
                                    :href="route('products.edit', product.id)"
                                    class="mr-3 text-sm text-blue-600 hover:text-blue-900"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="deleteProduct(product.id)"
                                    class="text-sm text-red-600 hover:text-red-900"
                                >
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    products.from
                                }}</span>
                                sampai
                                <span class="font-medium">{{
                                    products.to
                                }}</span>
                                dari
                                <span class="font-medium">{{
                                    products.total
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
                                    v-for="(link, i) in products.links"
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
                                            i === products.links.length - 1,
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
