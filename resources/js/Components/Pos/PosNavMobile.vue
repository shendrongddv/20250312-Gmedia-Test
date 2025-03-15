<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { onClickOutside } from "@vueuse/core";
import PosCartButton from "@/Components/Pos/PosCartButton.vue";
import { useCartStore } from "@/stores/cart";
import { computed } from "vue";

const isOpen = ref(false);
const menuRef = ref(null);

const emit = defineEmits(["open-cart", "open-category-modal"]);

const cartStore = useCartStore();
const cartItemsCount = computed(() => cartStore.totalItems);
const user = computed(() => usePage().props.auth.user);

onClickOutside(menuRef, () => {
    isOpen.value = false;
});

const toggleMenu = () => {
    isOpen.value = !isOpen.value;
};

const openCart = () => {
    emit("open-cart");
};

const openCategoryModal = () => {
    emit("open-category-modal");
};
</script>

<template>
    <div class="md:hidden">
        <!-- Toggle Button -->
        <div class="flex items-center">
            <div class="mr-2">
                <PosCartButton />
            </div>
            <button
                @click="toggleMenu"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900"
            >
                <span class="sr-only">Open main menu</span>
                <svg
                    v-if="!isOpen"
                    class="block h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
                <svg
                    v-else
                    class="block h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div
            v-show="isOpen"
            class="fixed inset-0 z-40 bg-black bg-opacity-25"
            @click="isOpen = false"
        ></div>

        <div
            v-show="isOpen"
            ref="menuRef"
            class="fixed inset-y-0 left-0 z-50 w-64 transform overflow-y-auto bg-white p-6 transition duration-300 ease-in-out"
        >
            <div class="flex items-center justify-between">
                <div class="text-xl font-bold text-gray-900">Menu</div>
                <button
                    @click="isOpen = false"
                    class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900"
                >
                    <span class="sr-only">Close menu</span>
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <div class="mt-6 space-y-4">
                <button
                    @click="openCategoryModal"
                    class="block w-full rounded-md bg-blue-600 px-4 py-2 text-left text-sm font-medium text-white hover:bg-blue-700"
                >
                    + Tambah Kategori
                </button>

                <Link
                    :href="route('products.create')"
                    class="block w-full rounded-md bg-blue-600 px-4 py-2 text-left text-sm font-medium text-white hover:bg-blue-700"
                >
                    + Tambah Produk
                </Link>

                <button
                    @click="openCart"
                    class="flex w-full items-center rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    <svg
                        class="mr-3 h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                        />
                    </svg>
                    Keranjang
                </button>

                <!-- Profile -->
                <div class="border-t pt-4">
                    <div class="flex items-center">
                        <img
                            class="h-8 w-8 rounded-full"
                            src="https://ui-avatars.com/api/?name=Admin"
                            alt=""
                        />
                        <span class="ml-3 text-sm font-medium text-gray-700"
                            >Admin</span
                        >
                    </div>
                </div>

                <Link
                    href="/categories"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    :class="{
                        'bg-gray-100': $page.url.startsWith('/categories'),
                    }"
                    @click="isOpen = false"
                >
                    Kategori
                </Link>
                <Link
                    href="/products"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    :class="{
                        'bg-gray-100': $page.url.startsWith('/products'),
                    }"
                    @click="isOpen = false"
                >
                    Produk
                </Link>
                <Link
                    href="/transactions"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    :class="{
                        'bg-gray-100': $page.url.startsWith('/transactions'),
                    }"
                    @click="isOpen = false"
                >
                    Transaksi
                </Link>
            </div>
        </div>
    </div>
</template>
