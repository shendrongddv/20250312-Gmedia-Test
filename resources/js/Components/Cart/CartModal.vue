<script setup>
import { ref } from "vue";
import { useCartStore } from "@/stores/cart";
import { formatPrice } from "@/utils/format";
import { router, Link } from "@inertiajs/vue3";

const cart = useCartStore();
const isOpen = ref(false);

const closeModal = () => {
    isOpen.value = false;
};

const handleCheckout = () => {
    router.post(
        route("transactions.store"),
        {
            items: cart.items,
            total_amount: cart.totalAmount,
        },
        {
            onSuccess: (response) => {
                cart.clearCart();
                closeModal();
            },
        },
    );
};

defineExpose({ isOpen });
</script>

<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0"
        >
            <!-- Background overlay -->
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="closeModal"
            ></div>

            <!-- Modal panel -->
            <div
                class="relative inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
            >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mt-3 w-full text-center sm:ml-4 sm:mt-0 sm:text-left"
                        >
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                                id="modal-title"
                            >
                                Keranjang Belanja
                            </h3>
                            <div class="mt-4">
                                <div
                                    v-if="cart.items.length === 0"
                                    class="text-center"
                                >
                                    Keranjang kosong
                                </div>
                                <div v-else class="space-y-4">
                                    <div
                                        v-for="item in cart.items"
                                        :key="item.id"
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <h4 class="font-medium">
                                                {{ item.name }}
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                {{ formatPrice(item.price) }} x
                                                {{ item.quantity }}
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <button
                                                @click="
                                                    cart.decreaseQuantity(
                                                        item.id,
                                                    )
                                                "
                                                class="rounded bg-gray-200 px-2 py-1 text-sm"
                                            >
                                                -
                                            </button>
                                            <span>{{ item.quantity }}</span>
                                            <button
                                                @click="cart.addToCart(item)"
                                                class="rounded bg-gray-200 px-2 py-1 text-sm"
                                            >
                                                +
                                            </button>
                                            <button
                                                @click="
                                                    cart.removeFromCart(item.id)
                                                "
                                                class="ml-2 text-red-600"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                    <div class="border-t pt-4">
                                        <div
                                            class="flex justify-between font-medium"
                                        >
                                            <span>Total:</span>
                                            <span>{{
                                                formatPrice(cart.totalAmount)
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                >
                    <button
                        v-if="cart.items.length > 0"
                        type="button"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="handleCheckout"
                    >
                        Checkout
                    </button>
                    <button
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                        @click="closeModal"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
