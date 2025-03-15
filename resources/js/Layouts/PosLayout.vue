<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import PosCartModal from "@/Components/Pos/PosCartModal.vue";
import PosCategoryModal from "@/Components/Pos/PosCategoryModal.vue";
import PosNavDesktop from "@/Components/Pos/PosNavDesktop.vue";
import PosNavMobile from "@/Components/Pos/PosNavMobile.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { computed } from "vue";
import { Head } from "@inertiajs/vue3";
import { useCartStore } from "@/stores/cart";

const props = defineProps({
    title: {
        type: String,
        default: "MASPOS",
    },
});

const cartModal = ref(null);
const categoryModal = ref(null);
const profileDropdownOpen = ref(false);
const profileDropdownRef = ref(null);

const openCart = () => {
    cartModal.value.isOpen = true;
};

// Toggle profile dropdown
const toggleProfileDropdown = () => {
    profileDropdownOpen.value = !profileDropdownOpen.value;
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (
        profileDropdownRef.value &&
        !profileDropdownRef.value.contains(event.target)
    ) {
        profileDropdownOpen.value = false;
    }
};

// Add and remove event listeners
onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

const categories = usePage().props.categories;

const showingNavigationDropdown = ref(false);
const user = computed(() => usePage().props.auth.user);

// Get cart count from store
const cartStore = useCartStore();
const cartCount = computed(() => cartStore.totalItems);
const cartTotalPrice = computed(() => cartStore.totalPrice);

// Check if route is active
const isActive = (routeName) => {
    return route().current(routeName);
};
</script>

<template>
    <Head>
        <title>{{ props.title }}</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <Link rel="icon" href="/favicon.ico" />
    </Head>
    <div class="min-h-screen space-y-8 bg-gray-50 md:px-4 md:pt-6">
        <!-- Header -->
        <header
            class="sticky left-0 top-0 z-50 grid gap-4 bg-white p-4 md:rounded-xl md:border"
        >
            <!-- Navbar -->
            <nav class="flex w-full items-center justify-between gap-4">
                <!-- Logo -->
                <Link href="/dashboard" class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <ApplicationLogo class="h-8 w-8 fill-blue-600" />
                        <span class="ml-2 text-xl font-bold text-blue-600"
                            >MASPOS</span
                        >
                    </div>
                </Link>

                <!-- Navigation -->
                <div class="hidden items-center space-x-4 md:flex">
                    <!-- Navigation Links -->
                    <Link
                        href="/dashboard"
                        :class="[
                            isActive('dashboard')
                                ? 'btn-solid bg-blue-600 text-white'
                                : 'btn-outline text-gray-700 hover:text-blue-600',
                            'rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                        ]"
                    >
                        Dashboard
                    </Link>
                    <Link
                        href="/categories"
                        :class="[
                            isActive('categories.*')
                                ? 'btn-solid bg-blue-600 text-white'
                                : 'btn-outline text-gray-700 hover:text-blue-600',
                            'rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                        ]"
                    >
                        Kategori
                    </Link>
                    <Link
                        href="/products"
                        :class="[
                            isActive('products.*')
                                ? 'btn-solid bg-blue-600 text-white'
                                : 'btn-outline text-gray-700 hover:text-blue-600',
                            'rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                        ]"
                    >
                        Produk
                    </Link>
                    <Link
                        href="/transactions"
                        :class="[
                            isActive('transactions.*')
                                ? 'btn-solid bg-blue-600 text-white'
                                : 'btn-outline text-gray-700 hover:text-blue-600',
                            'rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                        ]"
                    >
                        Transaksi
                    </Link>

                    <div class="flex items-center space-x-4">
                        <!-- Cart Modal Button -->
                        <!-- <button
                            @click="openCart"
                            class="btn-outline relative rounded-lg p-2 text-sm font-medium text-gray-700 transition-colors hover:text-blue-600"
                        >
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
                            <span
                                v-if="cartCount > 0"
                                class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white"
                            >
                                {{ cartCount }}
                            </span>
                        </button> -->

                        <!-- Cart Page Link -->
                        <Link
                            href="/cart"
                            :class="[
                                cartCount > 0
                                    ? 'h-12 w-auto bg-blue-500/50'
                                    : '',
                                // 'flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                                'isolate flex rounded-lg',
                            ]"
                        >
                            <div
                                class="btn-outline relative flex h-12 w-12 shrink-0 items-center justify-center rounded-lg p-2 text-sm font-medium text-gray-700 transition-colors hover:text-blue-600"
                            >
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
                                <span
                                    v-if="cartCount > 0"
                                    class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white"
                                >
                                    {{ cartCount }}
                                </span>
                            </div>

                            <div v-if="cartCount > 0" class="h-12 p-3">
                                Total Rp.{{ cartTotalPrice }}
                            </div>
                        </Link>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-3" ref="profileDropdownRef">
                        <div>
                            <button
                                @click="toggleProfileDropdown"
                                type="button"
                                :class="[
                                    isActive('profile.*') ? 'bg-gray-100' : '',
                                    'flex items-center rounded-lg px-3 py-2 text-sm transition-colors focus:outline-none',
                                ]"
                            >
                                <img
                                    class="h-8 w-8 rounded-full"
                                    :src="`https://ui-avatars.com/api/?name=${user.name}&background=random`"
                                    :alt="user.name"
                                />
                                <span
                                    class="ml-2 text-sm font-medium text-gray-700"
                                    >{{ user.name }}</span
                                >
                                <svg
                                    class="ml-1 h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div
                            v-if="profileDropdownOpen"
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5"
                        >
                            <Link
                                href="/profile"
                                :class="[
                                    isActive('profile.*')
                                        ? 'bg-gray-100 font-medium'
                                        : '',
                                    'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                                ]"
                            >
                                Profil
                            </Link>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Keluar
                            </Link>
                        </div>
                    </div>
                </div>
                <PosNavMobile @open-cart="openCart" />
            </nav>

            <!-- Slot -->
            <slot name="filter" />
        </header>

        <!-- Main Content -->
        <main class="">
            <slot></slot>
        </main>

        <!-- Cart Modal -->
        <PosCartModal ref="cartModal" />
        <PosCategoryModal ref="categoryModal" />
    </div>
</template>
