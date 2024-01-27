<script setup>
    import { Link } from '@inertiajs/vue3';
    
    const props = defineProps({
        stats: Object
    })

const data = [
    {
        title: 'Vehicles Available',
        value: props.stats.cars,
        link: '/inventory?availability=available'
    },
    {
        title: 'Vehicles Sold',
        value: props.stats.sold,
        link: '/inventory?availability=sold'
    },
    {
        title: 'Upcoming Vehicles',
        value: props.stats.upcoming,
        link: '/inventory?availability=upcoming'
    }
]
</script>
<template>
    <section class="flex justify-center">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-8">
            <Link :href="stat.link" v-for="stat in data" :key="stat.value">
                <div class="flex flex-col items-center justify-between p-2 md:gap-y-6 md:px-8 md:py-4 bg-red-800 text-gray-100 opacity-80 shadow rounded">
                    <h2 class="text-sm md:text-xl md:font-bold">{{ stat.title }}</h2>
                    <h3 class="text-sm md:text-3xl font-bold">{{ stat.value }}</h3>
                </div>
            </Link>
        </div>
    </section>
</template>