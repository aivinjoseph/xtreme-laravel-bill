<script setup>
const props = defineProps({
    stats: Object
})

const data = [
    {
        title: 'Inventory',
        value: props.stats.cars
    },
    {
        title: 'Cars Sold',
        value: props.stats.sold
    },
    {
        title: 'Upcoming Cars',
        value: props.stats.upcoming
    }
]
</script>
<template>
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="flex flex-col items-center justify-between gap-y-8 py-6 bg-gray-800 shadow rounded" v-for="stat in data" :key="stat.value">
                <h2 class="text-xl text-gray-200 font-bold">{{ stat.title }}</h2>
                <h3 class="text-3xl font-bold text-gray-200">{{ stat.value }}</h3>
            </div>
        </div>
    </section>
</template>