<script setup>
import { Head } from "@inertiajs/vue3";
import { useCartStore } from "@/stores/cart";
import { computed, ref } from "vue";
import PosLayout from "@/Layouts/PosLayout.vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";

const props = defineProps({
    categories: Array,
});

const cartStore = useCartStore();
const isProcessing = ref(false);

// Compute cart items
const cartItems = computed(() => {
    return cartStore.items;
});

// Compute total price
const totalPrice = computed(() => {
    return cartStore.totalPrice;
});

// Increase quantity
const increaseQuantity = (item) => {
    cartStore.increaseQuantity(item.id);
};

// Decrease quantity
const decreaseQuantity = (item) => {
    cartStore.decreaseQuantity(item.id);
};

// Remove item
const removeItem = (item) => {
    cartStore.removeItem(item.id);
};

// Clear cart
const clearCart = () => {
    cartStore.clearCart();
};

// Create form for checkout
const form = useForm({
    items: [],
    total_amount: 0,
});

// Process checkout
const processCheckout = () => {
    if (cartItems.value.length === 0) return;

    isProcessing.value = true;
    console.log("Starting checkout process...");

    // Prepare form data
    form.items = cartItems.value.map((item) => ({
        product_id: item.id,
        quantity: item.quantity,
        price: item.price,
        subtotal: item.price * item.quantity,
    }));
    form.total_amount = totalPrice.value;

    // Debug: Log form data
    console.log("Form data:", {
        items: cartItems.value.map((item) => ({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price,
            subtotal: item.price * item.quantity,
        })),
        total_amount: totalPrice.value,
    });

    // Submit form using Inertia
    form.post(route("transactions.store"), {
        onSuccess: () => {
            console.log("Form submitted successfully");
            cartStore.clearCart();
            isProcessing.value = false;
        },
        onError: (errors) => {
            console.error("Error submitting form:", errors);
            isProcessing.value = false;
            alert(
                "Terjadi kesalahan saat memproses transaksi. Silakan coba lagi.",
            );
        },
        onFinish: () => {
            console.log("Form submission finished");
        },
    });
};

// Filter state
const selectedCategory = ref(null);
const searchQuery = ref("");

// Handle category selection
const handleCategorySelect = (categoryId) => {
    selectedCategory.value = categoryId;
};

// Handle search
const handleSearch = (query) => {
    searchQuery.value = query;
};
</script>

<template>
    <Head title="Keranjang Belanja" />

    <PosLayout>
        <div class="mx-auto w-full px-4 py-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
                <Link
                    href="/dashboard"
                    class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                >
                    Kembali
                </Link>
            </div>

            <!-- Empty Cart -->
            <div
                v-if="cartItems.length === 0"
                class="rounded-lg border border-gray-200 bg-white p-8 text-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mx-auto mb-4 h-12 w-12 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <p class="mb-4 text-lg font-medium text-gray-500">
                    Keranjang belanja Anda kosong
                </p>
                <Link
                    href="/dashboard"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Mulai Belanja
                </Link>
            </div>

            <!-- Cart Items -->
            <div v-else class="space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white">
                    <div class="p-6">
                        <div class="mb-4 flex justify-between">
                            <h2 class="text-lg font-bold">Daftar Produk</h2>
                            <button
                                @click="clearCart"
                                class="text-sm text-red-600 hover:text-red-800"
                            >
                                Hapus Semua
                            </button>
                        </div>

                        <div class="divide-y">
                            <div
                                v-for="item in cartItems"
                                :key="item.id"
                                class="flex items-center gap-4 py-4"
                            >
                                <!-- Product Image -->
                                <div
                                    class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100"
                                >
                                    <img
                                        v-if="item.image"
                                        :src="`/storage/${item.image}`"
                                        :alt="item.name"
                                        class="h-full w-full object-cover object-center"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-500"
                                    >
                                        No Image
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ item.name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ formatPrice(item.price) }}
                                    </p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center">
                                    <button
                                        @click="decreaseQuantity(item)"
                                        class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-gray-100"
                                    >
                                        -
                                    </button>
                                    <span class="mx-2 w-8 text-center">{{
                                        item.quantity
                                    }}</span>
                                    <button
                                        @click="increaseQuantity(item)"
                                        class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-gray-100"
                                    >
                                        +
                                    </button>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="font-medium">
                                        Rp
                                        {{
                                            formatPrice(
                                                item.price * item.quantity,
                                            )
                                        }}
                                    </p>
                                </div>

                                <!-- Remove Button -->
                                <button
                                    @click="removeItem(item)"
                                    class="text-gray-400 hover:text-red-600"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="mb-4 text-lg font-bold">Ringkasan Pesanan</h2>
                    <div class="mb-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ formatPrice(totalPrice) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak</span>
                            <span>Rp 0</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span>Rp {{ formatPrice(totalPrice) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <form @submit.prevent="processCheckout">
                    <!-- Hidden inputs for form data -->
                    <div
                        v-for="(item, index) in cartItems"
                        :key="item.id"
                        class="hidden"
                    >
                        <input
                            type="hidden"
                            :name="`items[${index}][product_id]`"
                            :value="item.id"
                        />
                        <input
                            type="hidden"
                            :name="`items[${index}][quantity]`"
                            :value="item.quantity"
                        />
                        <input
                            type="hidden"
                            :name="`items[${index}][price]`"
                            :value="item.price"
                        />
                        <input
                            type="hidden"
                            :name="`items[${index}][subtotal]`"
                            :value="item.price * item.quantity"
                        />
                    </div>
                    <input
                        type="hidden"
                        name="total_amount"
                        :value="totalPrice"
                    />

                    <!-- Checkout Button -->
                    <div class="flex justify-end">
                        <button
                            :disabled="isProcessing"
                            class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700"
                            type="submit"
                        >
                            {{
                                isProcessing
                                    ? "Memproses..."
                                    : "Lanjutkan ke Pembayaran"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </PosLayout>
</template>
