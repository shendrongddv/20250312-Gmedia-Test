<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";

const props = defineProps({
    transaction: Object,
});

// Format date
const formatDate = (dateString) => {
    if (!dateString) return "";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    }).format(date);
};

// Format status
const getStatusBadgeClass = (status) => {
    switch (status) {
        case "completed":
            return "bg-green-100 text-green-800";
        case "pending":
            return "bg-yellow-100 text-yellow-800";
        case "cancelled":
            return "bg-red-100 text-red-800";
        default:
            return "bg-gray-100 text-gray-800";
    }
};

// Format payment status
const getPaymentStatusBadgeClass = (status) => {
    switch (status) {
        case "paid":
            return "bg-green-100 text-green-800";
        case "unpaid":
            return "bg-red-100 text-red-800";
        case "partial":
            return "bg-yellow-100 text-yellow-800";
        default:
            return "bg-gray-100 text-gray-800";
    }
};

// Translate status
const translateStatus = (status) => {
    const statusMap = {
        completed: "Selesai",
        pending: "Menunggu",
        cancelled: "Dibatalkan",
        paid: "Lunas",
        unpaid: "Belum Bayar",
        partial: "Sebagian",
    };

    return statusMap[status] || status;
};
</script>

<template>
    <Head title="Detail Transaksi" />

    <PosLayout title="Detail Transaksi">
        <div class="mx-auto max-w-4xl px-4 py-8">
            <!-- Header with back button -->
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Detail Transaksi</h1>
                <Link
                    href="/transactions"
                    class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                >
                    Kembali
                </Link>
            </div>

            <!-- Transaction Info Card -->
            <div class="mb-6 overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        Informasi Transaksi
                    </h2>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                ID Transaksi
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                #{{ transaction.id }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Tanggal
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ formatDate(transaction.created_at) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1 text-sm">
                                <span
                                    :class="[
                                        getStatusBadgeClass(transaction.status),
                                        'inline-flex rounded-full px-2 py-1 text-xs font-semibold',
                                    ]"
                                >
                                    {{ translateStatus(transaction.status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Status Pembayaran
                            </dt>
                            <dd class="mt-1 text-sm">
                                <span
                                    :class="[
                                        getPaymentStatusBadgeClass(
                                            transaction.payment_status,
                                        ),
                                        'inline-flex rounded-full px-2 py-1 text-xs font-semibold',
                                    ]"
                                >
                                    {{
                                        translateStatus(
                                            transaction.payment_status,
                                        )
                                    }}
                                </span>
                            </dd>
                        </div>
                        <div v-if="transaction.notes" class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">
                                Catatan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ transaction.notes }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Transaction Items -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        Daftar Produk
                    </h2>
                </div>
                <div class="overflow-x-auto">
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
                                    Harga
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Jumlah
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="item in transaction.items"
                                :key="item.id"
                            >
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900"
                                >
                                    {{ item.product_name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"
                                >
                                    Rp{{ formatPrice(item.price) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"
                                >
                                    {{ item.quantity }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"
                                >
                                    Rp{{ formatPrice(item.subtotal) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td
                                    colspan="3"
                                    class="px-6 py-4 text-right text-sm font-medium text-gray-500"
                                >
                                    Total
                                </td>
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900"
                                >
                                    Rp{{
                                        formatPrice(transaction.total_amount)
                                    }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-4">
                <Link
                    href="/transactions"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Kembali ke Daftar
                </Link>
                <Link
                    href="/dashboard"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
                >
                    Kembali ke Dashboard
                </Link>
            </div>
        </div>
    </PosLayout>
</template>
