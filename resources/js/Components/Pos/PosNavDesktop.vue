<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { useCartStore } from "@/stores/cart";
import { computed } from "vue";
import PosCartButton from "@/Components/Pos/PosCartButton.vue";

const emit = defineEmits(["open-cart", "open-category-modal"]);

const cartStore = useCartStore();
const cartItemsCount = computed(() => cartStore.totalItems);
const user = computed(() => usePage().props.auth.user);

const openCart = () => {
    emit("open-cart");
};

const openCategoryModal = () => {
    emit("open-category-modal");
};
</script>

<template>
    <div class="hidden items-center justify-center gap-4 md:flex">
        <!-- Navigation Links -->
        <Link
            href="/dashboard"
            class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            :class="{ 'bg-gray-100': $page.url === '/dashboard' }"
        >
            Dashboard
        </Link>
        <Link
            href="/categories"
            class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            :class="{ 'bg-gray-100': $page.url.startsWith('/categories') }"
        >
            Kategori
        </Link>
        <Link
            href="/products"
            class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            :class="{ 'bg-gray-100': $page.url.startsWith('/products') }"
        >
            Produk
        </Link>
        <Link
            href="/transactions"
            class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            :class="{ 'bg-gray-100': $page.url.startsWith('/transactions') }"
        >
            Transaksi
        </Link>

        <!-- Actions -->
        <div class="flex items-center space-x-4 md:border-r md:pr-4">
            <button
                @click="openCategoryModal"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                + Tambah Kategori
            </button>

            <Link
                :href="route('products.create')"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                + Tambah Produk
            </Link>

            <PosCartButton />
        </div>

        <!-- Profile -->
        <div class="flex items-center space-x-4">
            <div class="relative ml-3">
                <div class="flex items-center">
                    <button
                        type="button"
                        class="flex rounded-full bg-white text-sm"
                    >
                        <span class="sr-only">Open user menu</span>
                        <img
                            class="h-8 w-8 rounded-full"
                            src="https://ui-avatars.com/api/?name=Admin"
                            alt=""
                        />
                    </button>
                    <span class="ml-2 text-sm font-medium text-gray-700"
                        >Admin</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
