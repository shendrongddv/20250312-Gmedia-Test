<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useCartStore } from "@/stores/cart";
import { useProductStore } from "@/stores/product";
import { onMounted, watch, ref, computed } from "vue";
import PosProductList from "@/Components/Pos/PosProductList.vue";
import PosFilter from "@/Components/Pos/PosFilter.vue";

const props = defineProps({
    products: Object,
    categories: Object,
});

const cart = useCartStore();
const productStore = useProductStore();

// Initialize store with products from database
onMounted(() => {
    const productsData = props.products?.data || [];
    productStore.setProducts(productsData);
});

// Watch for props changes to update store
watch(
    () => props.products?.data,
    (newProducts) => {
        if (!newProducts) return;
        productStore.setProducts(newProducts);
    },
);

// Filter state
const selectedCategory = ref(null);
const searchQuery = ref("");

// Filtered products
const filteredProducts = computed(() => {
    let result = props.products.data;

    // Filter by category
    if (selectedCategory.value) {
        result = result.filter(
            (product) => product.category_id === selectedCategory.value,
        );
    }

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter((product) =>
            product.name.toLowerCase().includes(query),
        );
    }

    return result;
});

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
    <Head title="Dashboard" />

    <PosLayout>
        <template #filter>
            <!-- Filter Component -->
            <PosFilter
                :categories="categories"
                @category-select="handleCategorySelect"
                @search="handleSearch"
            />
        </template>

        <!-- Product List -->
        <div class="mt-6">
            <PosProductList :products="filteredProducts" />
        </div>
    </PosLayout>
</template>
