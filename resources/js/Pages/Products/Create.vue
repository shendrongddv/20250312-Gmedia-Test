<script setup>
import PosLayout from "@/Layouts/PosLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: "",
    description: "",
    price: "",
    stock: "",
    category_id: "",
    image: null,
});

const submit = () => {
    form.post(route("products.store"));
};

const handleImageUpload = (e) => {
    form.image = e.target.files[0];
};
</script>

<template>
    <Head title="Tambah Produk" />

    <PosLayout>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Produk
        </h2>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                                <InputLabel
                                    for="description"
                                    value="Deskripsi"
                                />
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
                                <InputLabel
                                    for="category_id"
                                    value="Kategori"
                                />
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
                                    Simpan
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </PosLayout>
</template>
