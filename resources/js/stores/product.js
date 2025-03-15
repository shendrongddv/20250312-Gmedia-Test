import { defineStore } from "pinia";
import { ref, computed } from "vue";

export const useProductStore = defineStore("product", () => {
    // State
    const products = ref([]);
    const searchQuery = ref("");
    const selectedCategory = ref(null);

    // Getters
    const filteredProducts = computed(() => {
        console.log("Current selectedCategory:", selectedCategory.value);
        let filtered = products.value;

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
            console.log("Filtering by category:", selectedCategory.value);
            filtered = filtered.filter(
                (product) => product.category_id === selectedCategory.value,
            );
        }

        console.log("Filtered products count:", filtered.length);
        return filtered;
    });

    // Actions
    function setProducts(newProducts) {
        products.value = newProducts;
    }

    function setSearchQuery(query) {
        searchQuery.value = query;
    }

    function setSelectedCategory(categoryId) {
        selectedCategory.value = categoryId;
    }

    function resetFilters() {
        searchQuery.value = "";
        selectedCategory.value = null;
    }

    return {
        products,
        searchQuery,
        selectedCategory,
        filteredProducts,
        setProducts,
        setSearchQuery,
        setSelectedCategory,
        resetFilters,
    };
});
