<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    mode: {
        type: String,
        default: "create",
    },
    category: {
        type: Object,
        default: null,
    },
});

const isOpen = ref(false);

const form = useForm({
    name: props.category?.name || "",
    description: props.category?.description || "",
    is_active: props.category?.is_active ?? true,
});

const submit = () => {
    if (props.mode === "create") {
        form.post(route("categories.store"), {
            onSuccess: () => {
                isOpen.value = false;
                form.reset();
            },
        });
    } else {
        form.put(route("categories.update", props.category.id), {
            onSuccess: () => {
                isOpen.value = false;
            },
        });
    }
};

defineExpose({ isOpen });
</script>

<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Background overlay -->
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="isOpen = false"
            ></div>

            <!-- Modal panel -->
            <div
                class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white p-6 text-left shadow-xl transition-all"
            >
                <div class="mb-5">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{
                            mode === "create"
                                ? "Tambah Kategori"
                                : "Edit Kategori"
                        }}
                    </h3>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Kategori
                        </label>
                        <input
                            type="text"
                            v-model="form.name"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Masukkan nama kategori"
                        />
                        <div
                            v-if="form.errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="isOpen = false"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                        >
                            {{ mode === "create" ? "Tambah" : "Simpan" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
