<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FeaturedItem from "@/Components/Cars/FeaturedItem.vue";
import { useForm } from '@inertiajs/vue3';
import SideFilters from '@/Components/Inventory/SideFilters.vue';
import TopFilters from '@/Components/Inventory/TopFilters.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    cars: {
        type: Object,
        required: true,
    },
    models: Array,
    makes: Array,
    colors: Array,
    trims: Array,
    drives: Array,
    fuels: Array,
    bodyTypes: Array,
    doors: Array,
    conditions: Array,
    transmissions: Array,
    features: Array,
    filters: Object,
});

const form = useForm({
    technical_condition: '',
    make: '',
    transmission: '',
    model: '',
    int_color: '',
    ext_color: '',
    body_type: '',
    drive: '',
    trim: '',
    fuel: '',
    door: '',
    mileage: [0, 300 * 1000],
    name: '',
    year: [1970, new Date().getFullYear()],
    price: [0, 300 * 1000],
    engine: '',
    seats: '',
    features: [],
    availability: '',
    ...props.filters,
});

const submit = () => {
    form.get(route('cars.inventory'));
};
</script>

<template>
    <AppLayout title="Inventory">
        <div class="flex p-8">
            <SideFilters :form="form" :colors="colors" :trims="trims" :drives="drives" :fuels="fuels" :body-types="bodyTypes" :doors="doors" :conditions="conditions" :features="features" :transmissions="transmissions" @submit="submit"/>
            <div class="max-w-7xl mx-auto col-span-2">
                <div class="w-full">
                    <TopFilters :models="models" :makes="makes" :form="form" @submit="submit"/>
                </div>
                <div class="py-4 flex items-center gap-2">
                    <h2 class="text-2xl font-bold">{{ cars.total }}</h2>
                    <p class="text-gray-500">Cars Available</p>
                </div>
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
                    <FeaturedItem v-for="car in cars.data" :key="car.id" :car="car" />
                </div>
                <div class="mt-8">
                    <Pagination :links="cars.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>