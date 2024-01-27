<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
const props = defineProps({
    revenue: String,
    total_cars: Number,
    sold_cars: Number,
})

const cards = [
    {
        title: 'Total Revenue',
        value: '$' + (+props.revenue).toLocaleString(
            undefined, // leave undefined to use the visitor's browser 
            // locale or a string like 'en-US' to override it.
            { minimumFractionDigits: 2 }
        ),
        icon: 'fas fa-dollar-sign',
        color: 'bg-green-500',
    },
    {
        title: 'Total Cars',
        value: props.total_cars,
        icon: 'fas fa-dollar-sign',
        color: 'bg-green-500',
    },
    {
        title: 'Total Cars Sold',
        value: props.sold_cars,
        icon: 'fas fa-car',
        color: 'bg-blue-500',
    },
]
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center justify-between p-2 md:gap-y-6 md:px-8 md:py-4 bg-red-800 text-gray-100 opacity-80 shadow rounded" v-for="card in cards" :key="card.value">
                        <h2 class="text-sm md:text-xl md:font-bold">{{ card.title }}</h2>
                        <h3 class="text-sm md:text-3xl font-bold">{{ card.value }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
