<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";

const props = defineProps({
    transaction: Object,
});

// Debug: Log transaction data
console.log("Transaction data:", props.transaction);

// Format date
const formatDate = (dateString) => {
    if (!dateString) return "";
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
    <Head title="Pembayaran Sukses" />

    <PosLayout>
        <div class="mx-auto max-w-md">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div
                    class="flex flex-col items-center justify-center p-8 text-center"
                >
                    <!-- Success Icon -->
                    <div
                        class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-10 w-10 text-white"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>

                    <!-- Success Message -->
                    <h2 class="mb-2 text-xl font-bold text-gray-900">
                        Pembayaran Sukses
                    </h2>

                    <!-- Transaction Details -->
                    <div v-if="transaction" class="mb-6 w-full">
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-900">
                            Rp{{ formatPrice(transaction.total_amount) }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ formatDate(transaction.created_at) }}
                        </p>
                    </div>
                    <div v-else class="mb-6 w-full">
                        <p class="text-sm text-gray-500">
                            Transaksi berhasil diproses
                        </p>
                    </div>

                    <!-- Back Button -->
                    <Link
                        href="/dashboard"
                        class="w-full rounded-lg bg-blue-600 px-4 py-2 text-center font-medium text-white hover:bg-blue-700"
                    >
                        Kembali
                    </Link>
                </div>
            </div>
        </div>
    </PosLayout>
</template>
