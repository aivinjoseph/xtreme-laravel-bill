<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
const services = [
    'Great Customer Service',
    'Hassle-free Financing',
    'Quality Pre-owned Vehicles',
    'No Hidden Fees or Costs',
    'Full Car History Disclosure',
    '100% Client Satisfaction'
]
</script>
<template>
    <AppLayout title="About Us">
        <div class="mx-auto max-w-3xl p-4 lg:p-8">
            <h1 class="text-2xl font-semibold text-gray-900">About Us</h1>
            <p class="mt-2 text-sm text-gray-500">
                Xtreme Motors Inc. is a leading used car dealership service provider in Toronto, Ontario offering high quality used cars for sale. From compact cars to sedans and SUV’s, we have an inventory of used cars from leading manufacturers. When it comes to used cars, we not only have the right expertise, but also the right connections. To ensure a satisfying experience, we sell only the finest vehicles providing exceptional value and performance. Being in the industry for past many years, our team knows what exactly you are looking for in a vehicle, and we stock the best inventory. We specialize in pre-owned luxury and compact automobiles, both cars & SUV.
            </p>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mt-4">Our Mission</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Our mission is to provide our customers with a hassle-free car buying experience. We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices. We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices.
                </p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mt-4">Our Vision</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Our vision is to be the best used car dealership service provider in Toronto, Ontario. We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices. We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices.
                </p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mt-4">Our Values</h2>
                <p class="mt-2 text-sm text-gray-500">
                    We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices. We are committed to providing our customers with the best possible service and support. We strive to provide our customers with the best quality used cars at the best possible prices.
                </p>
            </div>
            <div>
                <!-- Why Choose Us -->
                <h2 class="text-xl font-semibold text-gray-900 mt-4">Why Choose Us</h2>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <span v-for="service in services" :key="service">✔️ {{ service }}</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>