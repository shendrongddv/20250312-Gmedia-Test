import { defineStore } from "pinia";
import { ref, computed, watch } from "vue";

export const useCartStore = defineStore("cart", () => {
    // State
    const items = ref(JSON.parse(localStorage.getItem("cart-items") || "[]"));

    // Watch untuk menyimpan perubahan ke localStorage
    watch(
        items,
        (newItems) => {
            localStorage.setItem("cart-items", JSON.stringify(newItems));
        },
        { deep: true },
    );

    // Getters
    const totalItems = computed(() => {
        return items.value.reduce((total, item) => total + item.quantity, 0);
    });

    const totalPrice = computed(() => {
        return items.value.reduce((total, item) => {
            return total + item.price * item.quantity;
        }, 0);
    });

    // Actions
    function addItem(product) {
        // Periksa stok produk
        if (product.stock <= 0) {
            console.warn("Produk habis stok:", product.name);
            return;
        }

        const existingItem = items.value.find((item) => item.id === product.id);

        if (existingItem) {
            // Periksa apakah penambahan melebihi stok
            if (existingItem.quantity >= product.stock) {
                console.warn(
                    "Jumlah melebihi stok yang tersedia:",
                    product.name,
                );
                return;
            }
            existingItem.quantity += 1;
        } else {
            console.log("Adding product to cart:", product);
            items.value.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image_url,
                stock: product.stock,
                quantity: 1,
                category_id: product.category_id,
                category_name: product.category?.name || "Uncategorized",
            });
        }

        console.log("Cart updated:", items.value);
        console.log("Total items:", totalItems.value);
        console.log("Total price:", totalPrice.value);

        // Save to localStorage
        saveToLocalStorage();
    }

    function removeItem(productId) {
        const index = items.value.findIndex((item) => item.id === productId);
        if (index !== -1) {
            items.value.splice(index, 1);
        }
    }

    function increaseQuantity(productId) {
        const item = items.value.find((item) => item.id === productId);
        if (item) {
            // Periksa apakah penambahan melebihi stok
            if (item.quantity >= item.stock) {
                console.warn("Jumlah melebihi stok yang tersedia");
                return;
            }
            item.quantity += 1;
        }
    }

    function decreaseQuantity(productId) {
        const item = items.value.find((item) => item.id === productId);
        if (item && item.quantity > 1) {
            item.quantity -= 1;
        } else if (item && item.quantity === 1) {
            removeItem(productId);
        }
    }

    function clearCart() {
        items.value = [];
    }

    return {
        items,
        totalItems,
        totalPrice,
        addItem,
        removeItem,
        increaseQuantity,
        decreaseQuantity,
        clearCart,
    };
});
