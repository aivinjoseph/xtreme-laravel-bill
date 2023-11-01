<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ImageGallery from '@/Components/ImageGallery.vue';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    car: {
        type: Object,
        default: () => { }
    }
})

const data = [
    { name: 'Make', value: props.car.make },
    { name: 'Model', value: props.car.model },
    { name: 'Year', value: props.car.year },
    { name: 'Mileage', value: props.car.mileage + ' ' + props.car.mileage_unit },
    { name: 'Fuel Type', value: props.car.fuel },
    { name: 'Engine', value: props.car.engine },
    { name: 'Transmission', value: props.car.transmission },
    { name: 'Condition', value: props.car.technical_condition },
    { name: 'Body Type', value: props.car.body_type },
    { name: 'Int Color', value: props.car.int_color },
    { name: 'Ext Color', value: props.car.ext_color },
    { name: 'Doors', value: props.car.door },
    { name: 'Seats', value: props.car.seats },
    { name: 'Trim', value: props.car.trim },
    { name: 'Drive', value: props.car.drive },
]
</script>

<template>
    <AppLayout :title="car.name">
        <section class="max-w-7xl mx-auto p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex justify-between items-end pb-0">
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ car.name }}</div>
                            <div class="text-gray-500">{{ car.model }}</div>
                        </div>
                        <div class="font-bold text-xl text-gray-800">
                            ${{ car.price }}
                        </div>
                    </div>
                    <ImageGallery :images="car.images" :availability="car.availability" :featured-image-index="car.featured_image_index"/>
                    <div class="">
                        <div class="mt-4">
                            <h2 class="text-xl font-bold text-gray-800">Features</h2>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4 text-gray-700 font-semibold">
                                <span v-for="feature in car.features" :key="feature">✔️ {{ feature }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-xl font-bold text-gray-800">Description</h2>
                            <div class="mt-2 text-gray-700" v-html="car.description"></div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 p-4">
                    <Link :href="`/test-booking?car_id=${car.id}`">
                        <PrimaryButton class="w-full h-12">Book a Test Drive</PrimaryButton>
                    </Link>
                    <!-- <div class="text-xl font-bold text-gray-800">Car Details</div> -->
                    <div class="mt-4 bg-gray-100 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div v-for="item in data" :key="item.name">
                                <div class="font-bold text-gray-700">{{ item.name }}</div>
                                <div class="text-gray-500">{{ item.value }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>