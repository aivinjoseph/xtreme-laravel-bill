<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import SliderItem from "@/Components/Home/SliderItem.vue";
import { ref } from "vue";

const modules = ref([Autoplay, Pagination, Navigation]);
const onSwiper = (swiper) => {
    console.log(swiper);
};

const onSlideChange = () => {
    console.log("slide change");
};
</script>
<template>
    <div class="relative">
        <div class="absolute top-0 left-0 w-full h-full flex items-center z-30 pointer-events-none">
            <div class="w-full max-w-7xl mx-auto grid grid-cols-12 px-4">
                <div class="col-span-12 text-center ltablet:text-left lg:text-left ltablet:col-span-5 lg:col-span-5 space-y-4">
                    <h1 class="font-sans font-semibold text-5xl ltablet:text-6xl lg:text-7xl leading-none text-white">
                        Premium cars and vehicles
                    </h1>
                    <p class="font-sans text-lg text-white max-w-md mx-auto ltablet:mx-0 lg:mx-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Ex ea difficultate illae fallaciloquae, ut ait.
                    </p>
                </div>
            </div>
        </div>

        <swiper :spaceBetween="0" :centeredSlides="true" :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
        }" :pagination="{
    clickable: true,
}" :navigation="false" :modules="modules" class="mySwiper">
            <swiper-slide>
                <SliderItem :index="0" image="/img/bg/2.png" />
            </swiper-slide>
            <swiper-slide>
                <SliderItem :index="0" image="/img/bg/4.png" />
            </swiper-slide>
            <swiper-slide>
                <SliderItem :index="0" image="/img/bg/1.jpeg" />
            </swiper-slide>
        </swiper>
        <!--Slider-->
    </div>
</template>
<style>
.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;

    /* Center slide text vertically */
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
