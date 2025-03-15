<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex min-h-screen bg-gray-50 md:p-6">
        <!-- Left Side - Image -->
        <div class="hidden rounded-[40px] bg-blue-600 lg:flex lg:flex-1">
            <div class="relative w-full">
                <!-- Background Image -->
                <img
                    src="/images/auth-bg.jpg"
                    alt="Background"
                    class="absolute inset-0 h-full w-full object-cover opacity-20"
                />

                <!-- Content -->
                <div
                    class="relative z-10 flex h-full flex-col items-start justify-center px-16"
                >
                    <ApplicationLogo class="h-20 w-20 fill-white" />
                    <h1 class="mt-8 text-4xl font-bold text-white">
                        Desain yang user-friendly membuat navigasi cepat dan
                        mudah, bahkan bagi pemula.
                    </h1>
                    <p class="mt-4 text-lg text-white/80">
                        MASPOS menghadirkan solusi point-of-sale terbaik untuk
                        kemudahan operasional sehari-hari.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div
            class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20"
        >
            <div class="md:min-w-s mx-auto w-full max-w-sm">
                <div class="mb-8 flex justify-center lg:hidden">
                    <ApplicationLogo class="h-16 w-16 fill-blue-600" />
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
