<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Hero from "@/Components/Home/Hero.vue";
import Featured from "@/Components/Home/Featured.vue";
import UpcomingCars from "@/Components/Home/UpcomingCars.vue";
import OurBrands from "@/Components/Home/OurBrands.vue";
import Testimonials from "@/Components/Home/Testimonials.vue";
import TestBooking from "@/Components/Home/TestBooking.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    featuredCars: {
        type: Array,
        required: true,
    },
    upcomingCars: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    },
    stats: Object,
    homeImages: Array,
});

</script>

<template>
    <AppLayout title="Home">
        <div class="w-full min-h-screen mx-auto bg-white dark:bg-muted-900">
            <!--Hero-->
            <Hero :stats="stats" :home-images="homeImages"/>
            <div class="container mt-8 max-w-7xl mx-auto px-4 lg:px-12">
                <div class="mt-8"></div>

                <!--Featured-->
                <Featured :cars="featuredCars" />
    
                <div class="mt-8"></div>
                <UpcomingCars :cars="upcomingCars" />
    
                <div class="w-full flex justify-center py-4 mt-4">
                    <Link href="/inventory">
                        <primary-button>Explore Inventory</primary-button>
                    </Link>
                </div>
    
                <!--Brands-->
                <OurBrands :brands="brands"/>
    
                <!--Highlight-->
    
                <!--Testimonials-->
                <Testimonials />
    
                <!--CTA-->
                <TestBooking />
            </div>  
        </div>
    </AppLayout>
</template>

<style></style>
