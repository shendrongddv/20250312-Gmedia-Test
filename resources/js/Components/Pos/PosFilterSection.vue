<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useProductStore } from "@/stores/product";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["update:filteredProducts"]);

const productStore = useProductStore();
const searchQuery = ref("");
const selectedCategory = ref("");

// Ensure we emit initial products on mount
onMounted(() => {
    const initialProducts = usePage().props.products?.data || [];
    emit("update:filteredProducts", initialProducts);
});

const products = computed(() => {
    // Get products from store or props
    let filtered = productStore.products || [];

    // If products is empty, try to get from page props
    if (filtered.length === 0 && usePage().props.products) {
        filtered = usePage().props.products.data || [];

        // If we still don't have products, try the raw products prop
        if (filtered.length === 0) {
            filtered = usePage().props.products || [];
        }
    }

    // Log for debugging
    console.log("Products before filtering:", filtered);

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(
            (product) =>
                product.name.toLowerCase().includes(query) ||
                (product.description &&
                    product.description.toLowerCase().includes(query)),
        );
    }

    // Filter by category
    if (selectedCategory.value) {
        filtered = filtered.filter(
            (product) => product.category_id === selectedCategory.value,
        );
    }

    // Log for debugging
    console.log("Products after filtering:", filtered);

    // Emit filtered products to parent
    emit("update:filteredProducts", filtered);

    return filtered;
});

// Reset filters when products change
watch([() => productStore.products, () => usePage().props.products], () => {
    searchQuery.value = "";
    selectedCategory.value = "";
});
</script>

<template>
    <div class="space-y-4">
        <!-- Filter Section -->
        <div class="space-y-4">
            <!-- Search Bar -->
            <div class="relative">
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                >
                    <svg
                        class="h-5 w-5 text-gray-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <input
                    type="text"
                    v-model="searchQuery"
                    class="block w-full rounded-lg border-0 py-2 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
                    placeholder="Cari menu produk..."
                />
            </div>

            <!-- Categories -->
            <div
                class="no-scrollbar flex space-x-2 overflow-x-auto whitespace-nowrap"
            >
                <button
                    @click="selectedCategory = ''"
                    :class="[
                        'rounded-lg border-0 px-4 py-2 text-sm font-medium ring-1 ring-inset transition-colors',
                        !selectedCategory
                            ? 'bg-blue-600 text-white ring-blue-600 hover:bg-blue-700'
                            : 'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50',
                    ]"
                >
                    Semua
                </button>
                <button
                    v-for="category in categories"
                    :key="category.id"
                    @click="selectedCategory = category.id"
                    :class="[
                        'rounded-lg border-0 px-4 py-2 text-sm font-medium ring-1 ring-inset transition-colors',
                        selectedCategory === category.id
                            ? 'bg-blue-600 text-white ring-blue-600 hover:bg-blue-700'
                            : 'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50',
                    ]"
                >
                    {{ category.name }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Hide scrollbar but keep functionality */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
