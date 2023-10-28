<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FeaturedItem from "@/Components/Cars/FeaturedItem.vue";
import { useForm, Link } from '@inertiajs/vue3';
import SideFilters from '@/Components/Inventory/SideFilters.vue';
import TopFilters from '@/Components/Inventory/TopFilters.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
        <div class="flex mx-auto max-w-screen-xl flex-col md:flex-row p-8">
            <div class="w-1/4">
                <SideFilters :form="form" :colors="colors" :trims="trims" :drives="drives" :fuels="fuels" :body-types="bodyTypes" :doors="doors" :conditions="conditions" :features="features" :transmissions="transmissions" @submit="submit"/>
            </div>
            <div class="w-3/4 max-w-7xl md:px-4">
                <div class="w-full mt-4 md:mt-0">
                    <TopFilters :models="models" :makes="makes" :form="form" @submit="submit"/>
                </div>
                <div class="flex justify-between items-center">
                    <div class="py-4 mt-4 flex items-center gap-2">
                        <h2 class="text-2xl font-bold">{{ cars.total }}</h2>
                        <p class="text-gray-500">Cars Available</p>
                    </div>
                    <PrimaryButton><Link href="/cars/create">Add new car</Link></PrimaryButton>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <FeaturedItem v-for="car in cars.data" :key="car.id" :car="car" />
                </div>
                <div class="mt-8">
                    <Pagination :links="cars.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>