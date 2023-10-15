<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Hero from "@/Components/Home/Hero.vue";
import Featured from "@/Components/Home/Featured.vue";
import UpcomingCars from "@/Components/Home/UpcomingCars.vue";
import OurBrands from "@/Components/Home/OurBrands.vue";
import Highlights from "@/Components/Home/Highlights.vue";
import Testimonials from "@/Components/Home/Testimonials.vue";
import TestBooking from "@/Components/Home/TestBooking.vue";
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
});

</script>

<template>
    <AppLayout title="Home">
        <div class="w-full min-h-screen mx-auto bg-white dark:bg-muted-900">
            <!--Hero-->
            <Hero />
            <div class="container mt-8 max-w-7xl mx-auto px-4 lg:px-12">
                <!--Featured-->
                <Featured :cars="featuredCars" />
    
                <div class="mt-8"></div>
                <UpcomingCars :cars="upcomingCars" />
    
                <div class="w-full flex justify-center py-4 mt-4">
                    <Link href="/inventory" class="
                          relative
                          font-sans font-normal
                          inline-flex
                          items-center
                          justify-center
                          leading-5
                          no-underline
                          min-w-[240px]
                          space-x-1
                          text-white
                          bg-gray-800
                          dark:bg-gray-900
                          h-14
                          px-5
                          py-3
                          text-base
                          hover:bg-gray-700
                          dark:hover:bg-gray-1000
                          tw-accessibility
                          transition-all
                          duration-300
                          rounded
                        ">
                        Explore Inventory
                    </Link>
                </div>
    
                <!--Brands-->
                <OurBrands :brands="brands"/>
    
                <!--Highlight-->
                <Highlights />
    
                <!--Testimonials-->
                <Testimonials />
    
                <!--CTA-->
                <TestBooking />
            </div>  
        </div>
    </AppLayout>
</template>

<style></style>
