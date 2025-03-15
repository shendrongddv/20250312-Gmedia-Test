<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

const props = defineProps({
    product: Object,
    categories: Array,
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    is_active: props.product.is_active,
    category_id: props.product.category_id,
    image: null,
    _method: "PUT",
});

const showExistingImage = ref(true);

const removeImage = () => {
    if (form.image) {
        form.image = null;
    } else {
        showExistingImage.value = false;
        form._method = "put";
        form.image = "remove";
    }
};

const submit = () => {
    form.post(route("products.update", props.product.id));
};

const handleImageUpload = (e) => {
    form.image = e.target.files[0];
};

const fileInput = ref(null);
</script>

<template>
    <Head title="Edit Produk" />

    <PosLayout>
        <div class="mx-auto w-full max-w-xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form
                        @submit.prevent="submit"
                        enctype="multipart/form-data"
                    >
                        <div class="mb-4">
                            <InputLabel for="name" value="Nama" />
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="description" value="Deskripsi" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                rows="3"
                            ></textarea>
                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="price" value="Harga" />
                            <TextInput
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.price"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.price"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="stock" value="Stok" />
                            <TextInput
                                id="stock"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.stock"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.stock"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="category_id" value="Kategori" />
                            <select
                                id="category_id"
                                v-model="form.category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <InputError
                                class="mt-2"
                                :message="form.errors.category_id"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="image" value="Gambar" />
                            <div v-if="product.image" class="mb-2">
                                <img
                                    :src="`/storage/${product.image}`"
                                    alt="Product Image"
                                    class="h-32 w-32 object-cover"
                                />
                            </div>
                            <input
                                id="image"
                                type="file"
                                class="mt-1 block w-full"
                                @input="handleImageUpload"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.image"
                            />
                        </div>

                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton
                                class="ml-4"
                                :disabled="form.processing"
                            >
                                Perbarui
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PosLayout>
</template>
