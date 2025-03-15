<script setup>
import { ref, watch } from "vue";
import { useProductStore } from "@/stores/product";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const productStore = useProductStore();
const searchQuery = ref("");
const selectedCategory = ref(null);

// Watch for search query changes
watch(searchQuery, (newQuery) => {
    productStore.setSearchQuery(newQuery);
});

// Watch for category changes
watch(selectedCategory, (newCategory) => {
    productStore.setSelectedCategory(newCategory);
});

// Reset filters
const resetFilters = () => {
    searchQuery.value = "";
    selectedCategory.value = null;
    productStore.resetFilters();
};

// Clear search
const clearSearch = () => {
    searchQuery.value = "";
    productStore.setSearchQuery("");
};
</script>

<template>
    <div class="grid gap-4 md:flex md:items-center">
        <!-- Search Bar -->
        <div class="relative w-full max-w-md">
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
                class="block w-full rounded-lg border-0 py-2 pl-10 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
                placeholder="Cari menu produk..."
            />
            <!-- Clear search button -->
            <button
                v-if="searchQuery"
                @click="clearSearch"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                type="button"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"
                    />
                </svg>
            </button>
        </div>

        <!-- Categories -->
        <div
            class="no-scrollbar flex space-x-2 overflow-x-auto whitespace-nowrap"
        >
            <button
                @click="selectedCategory = null"
                :class="[
                    'rounded-lg border-0 px-4 py-2 text-sm font-medium ring-1 ring-inset transition-colors',
                    selectedCategory === null
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
