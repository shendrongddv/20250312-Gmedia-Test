<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";
import { ref } from "vue";

const props = defineProps({
    transactions: Object,
});

// Format date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    }).format(date);
};
</script>

<template>
    <Head title="Riwayat Transaksi" />

    <PosLayout>
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>
            <p class="mt-1 text-sm text-gray-500">
                Daftar semua transaksi yang telah Anda lakukan
            </p>
        </div>

        <!-- Transactions List -->
        <div
            class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
        >
            <div
                v-if="transactions.data.length === 0"
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
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                    />
                </svg>
                <p class="mb-2 text-lg font-medium text-gray-900">
                    Belum ada transaksi
                </p>
                <p class="mb-6 text-sm text-gray-500">
                    Transaksi yang Anda lakukan akan muncul di sini
                </p>
                <Link
                    href="/dashboard"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                >
                    Mulai Belanja
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
                                    ID Transaksi
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Tanggal
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Total
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
                                v-for="transaction in transactions.data"
                                :key="transaction.id"
                                class="hover:bg-gray-50"
                            >
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        #{{ transaction.id }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-500">
                                        {{ formatDate(transaction.created_at) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        Rp
                                        {{
                                            formatPrice(
                                                transaction.total_amount,
                                            )
                                        }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                                    >
                                        {{ transaction.status }}
                                    </span>
                                </td>
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium"
                                >
                                    <Link
                                        :href="
                                            route(
                                                'transactions.show',
                                                transaction.id,
                                            )
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        Detail
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile List -->
                <div class="divide-y divide-gray-200 md:hidden">
                    <div
                        v-for="transaction in transactions.data"
                        :key="transaction.id"
                        class="p-4 hover:bg-gray-50"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">
                                    #{{ transaction.id }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ formatDate(transaction.created_at) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">
                                    Rp
                                    {{ formatPrice(transaction.total_amount) }}
                                </p>
                                <span
                                    class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                                >
                                    {{ transaction.status }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-end">
                            <Link
                                :href="
                                    route('transactions.show', transaction.id)
                                "
                                class="text-sm font-medium text-blue-600 hover:text-blue-900"
                            >
                                Detail
                            </Link>
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
                                    transactions.from
                                }}</span>
                                sampai
                                <span class="font-medium">{{
                                    transactions.to
                                }}</span>
                                dari
                                <span class="font-medium">{{
                                    transactions.total
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
                                    v-for="(link, i) in transactions.links"
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
                                            i === transactions.links.length - 1,
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
