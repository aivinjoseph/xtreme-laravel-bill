<script setup>
    import { Link } from '@inertiajs/vue3';

    defineProps({
        brands: {
            type: Array,
            required: true,
        },
    })
</script>

<template>
    <section class="py-12 bg-white overflow-hidden">
        <div class="w-full">
            <!--Section title-->
            <div class="w-full max-w-xl space-y-2 py-6">
                <h2 class="font-heading font-light text-3xl md:text-4xl text-gray-800">
                    Our Brands
                </h2>
                <!--Subtitle-->
                <p class="font-sans font-light text-lg text-gray-500">
                    From used Audis to Porches we carry a large collection of premium quality used luxury cars in our inventory.
                </p>
            </div>

            <!--Grid-->
            <div class="py-4 grid grid-cols-2 lg:grid-cols-5 gap-4">
                <Link class="flex flex-col items-center justify-center bg-gray-100 rounded p-4 hover:shadow hover:bg-gray-50" v-for="brand in brands" :key="brand.id" :href="`/inventory?make=${brand.name}`">
                    <span class="flex justify-center">
                        <img :src="brand.logo" class="w-24 h-24 object-cover object-center" />
                    </span>
                    <h2 class="mt-1 text-gray-800 font-semibold">{{ brand.name }}</h2>
                    <span class="mt-1 text-gray-500 text-sm">{{ brand.cars_count }} vehicles available</span>
                </Link>
            </div>
        </div>
    </section>
</template>
