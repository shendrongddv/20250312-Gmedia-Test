<script setup>
import { useCartStore } from "@/stores/cart";
import { formatPrice } from "@/utils/format";
import { ref } from "vue";

const PLACEHOLDER_IMAGE =
    "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88B8AAsUB4ZtvXtIAAAAASUVORK5CYII=";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const cartStore = useCartStore();
const imageFailed = ref(false);

// Handle image loading error
const handleImageError = (e) => {
    if (imageFailed.value) return; // Prevent infinite loop
    imageFailed.value = true;
    e.target.src = PLACEHOLDER_IMAGE;
};

// Add product to cart
const addToCart = () => {
    // Tambahkan produk ke keranjang menggunakan metode addItem
    cartStore.addItem(props.product);
    console.log("Produk ditambahkan ke keranjang:", props.product);
    console.log("Jumlah item di keranjang:", cartStore.totalItems);
};
</script>

<template>
    <div
        class="group flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md"
    >
        <!-- Product Image -->
        <div class="relative aspect-square overflow-hidden bg-gray-100">
            <img
                v-if="product.image"
                :src="
                    imageFailed.value
                        ? PLACEHOLDER_IMAGE
                        : product.image
                          ? `/storage/${product.image}`
                          : PLACEHOLDER_IMAGE
                "
                :alt="product.name"
                class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                @error="handleImageError"
            />
            <div
                v-else
                class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-500"
            >
                No Image
            </div>
            <!-- Stock Badge -->
            <div
                v-if="product.stock <= 5 && product.stock > 0"
                class="absolute right-2 top-2 rounded-full bg-yellow-500 px-2 py-1 text-xs font-bold text-white"
            >
                Stok: {{ product.stock }}
            </div>
            <div
                v-else-if="product.stock === 0"
                class="absolute right-2 top-2 rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white"
            >
                Habis
            </div>
        </div>

        <!-- Product Info -->
        <div class="flex flex-1 flex-col p-4">
            <h3 class="mb-1 text-sm font-medium text-gray-900">
                {{ product.name }}
            </h3>
            <p
                v-if="product.description"
                class="mb-2 line-clamp-2 flex-1 text-xs text-gray-500"
            >
                {{ product.description }}
            </p>
            <div class="mt-auto flex items-center justify-between">
                <span class="text-sm font-bold text-gray-900">
                    Rp {{ formatPrice(product.price) }}
                </span>
                <div class="flex items-center gap-2">
                    <span
                        class="text-xs text-gray-500"
                        v-if="product.stock > 5"
                    >
                        Stok: {{ product.stock }}
                    </span>
                    <button
                        @click="addToCart"
                        :disabled="product.stock === 0"
                        :class="[
                            'rounded-full p-2 text-white shadow-sm transition-colors',
                            product.stock === 0
                                ? 'cursor-not-allowed bg-gray-400'
                                : 'bg-blue-600 hover:bg-blue-700',
                        ]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
