<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <section class="flex min-h-screen bg-gray-50 md:p-6">
        <main class="container flex min-h-screen items-center justify-center">
            <!-- Left Side - Image -->
            <div
                class="hidden h-full w-full rounded-[40px] bg-gradient-to-r from-[#4288F2] to-[#113E82] md:flex md:w-7/12 md:items-center md:justify-center"
            >
                <div class="relative w-full">
                    <div
                        class="relative z-10 flex h-full flex-col items-start justify-center px-16"
                    >
                        <ApplicationLogo class="h-20 w-20 fill-white" />
                        <h1 class="mt-8 text-4xl font-bold text-white">
                            Desain yang user-friendly membuat navigasi cepat dan
                            mudah, bahkan bagi pemula.
                        </h1>
                        <p class="mt-4 text-lg text-white/80">
                            MASPOS menghadirkan solusi point-of-sale terbaik
                            untuk kemudahan operasional sehari-hari.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div
                class="flex h-full w-full items-center justify-center p-4 md:w-5/12"
            >
                <div class="w-full max-w-sm">
                    <slot />
                </div>
            </div>
        </main>
    </section>
</template>
