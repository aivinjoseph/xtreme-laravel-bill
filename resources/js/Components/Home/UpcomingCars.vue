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
            <h2 class="font-heading font-light text-2xl md:text-3xl text-gray-800 dark:text-white">
                Upcoming Vehicles
            </h2>
            <p class="font-sans font-light text-lg text-gray-500 dark:text-gray-400">
                No matter, which vehicle model you are looking for, we have almost all of them. 
            </p>
        </div>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8">
            <FeaturedItem v-for="car in cars" :key="car.id" :car="car" />
        </div>
    </div>
</template>