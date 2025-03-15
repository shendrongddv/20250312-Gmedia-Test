<script setup>
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
import { useCartStore } from "@/stores/cart";

const isOpen = ref(false);
const menuRef = ref(null);

const emit = defineEmits(["open-cart", "open-category-modal"]);

const cartStore = useCartStore();

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
        </div>
    </div>
</template>
