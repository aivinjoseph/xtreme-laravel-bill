<script setup>
    import FeaturedItem from '@/Components/Cars/FeaturedItem.vue'
    defineProps({
        cars: {
            type: Array,
            required: true
        }
    })
</script>

<template>
    <div class="container">
        <div class="w-full text-left space-y-2">
            <div class="flex justify-between items-end">
                <h2 class="font-heading font-light text-2xl md:text-3xl text-gray-800 dark:text-white">
                    Featured Vehicles
                </h2>
                <a href="/inventory?featured=1" class="text-blue-500">View All</a>
            </div>
            <p class="md:w-1/2 font-sans font-light text-lg text-gray-500 dark:text-gray-400">
                These are our featured vehicles. Treat deals that we feel deserve a little more attention than the rest.
            </p>
        </div>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <FeaturedItem v-for="car in cars" :key="car.id" :car="car" />
        </div>
    </div>
</template>