<script setup>
import { computed } from "vue";
import { useCartStore } from "@/stores/cart";
import { Link } from "@inertiajs/vue3";

const cartStore = useCartStore();

// Compute total items in cart
const totalItems = computed(() => {
    return cartStore.totalItems;
});

// Compute total price
const totalPrice = computed(() => {
    return cartStore.totalPrice;
});

// Format price to IDR
const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};
</script>

<template>
    <Link
        href="/cart"
        class="flex items-center gap-3 rounded-lg bg-blue-600 px-4 py-3 text-white transition-colors hover:bg-blue-700 md:px-6"
    >
        <!-- Cart Icon with Badge -->
        <div class="relative">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
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
            <!-- Badge -->
            <div
                v-if="totalItems > 0"
                class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold"
            >
                {{ totalItems }}
            </div>
        </div>

        <!-- Total Price -->
        <div v-if="totalItems > 0" class="hidden text-sm md:block">
            <div class="font-medium">Total Tagihan</div>
            <div class="font-bold">Rp {{ formatPrice(totalPrice) }}</div>
        </div>
    </Link>
</template>
