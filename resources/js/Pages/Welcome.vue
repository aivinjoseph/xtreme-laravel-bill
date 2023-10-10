<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Hero from "@/Components/Home/Hero.vue";
import Featured from "@/Components/Home/Featured.vue";
import OurBrands from "@/Components/Home/OurBrands.vue";
import Highlights from "@/Components/Home/Highlights.vue";
import Testimonials from "@/Components/Home/Testimonials.vue";
import TestBooking from "@/Components/Home/TestBooking.vue";

const props = defineProps({
    featuredCars: {
        type: Array,
        required: true,
    },
});
console.log(props.featuredCars);
</script>

<template>
    <AppLayout title="Home">
        <div class="w-full min-h-screen mx-auto bg-white dark:bg-muted-900">
            <!--Hero-->
            <Hero />        

            <!--Featured-->
            <Featured :cars="featuredCars" />

            <!--Brands-->
            <OurBrands />

            <!--Highlight-->
            <Highlights />

            <!--Testimonials-->
            <Testimonials />

            <!--CTA-->
            <TestBooking />

            <!--End Layout-->
        </div>
    </AppLayout>
</template>

<style></style>
