<script setup>
import { computed } from "vue";
import { useProductStore } from "@/stores/product";
import PosProductCard from "@/Components/Pos/PosProductCard.vue";

const productStore = useProductStore();

// Get filtered products from store
const filteredProducts = computed(() => {
    return productStore.filteredProducts;
});
</script>

<template>
    <div>
        <!-- Empty state -->
        <div v-if="filteredProducts.length === 0" class="py-12 text-center">
            <p class="text-gray-500">Tidak ada produk yang ditemukan</p>
        </div>

        <!-- Product grid -->
        <div
            v-else
            class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6"
        >
            <PosProductCard
                v-for="product in filteredProducts"
                :key="product.id"
                :product="product"
            />
        </div>
    </div>
</template>
