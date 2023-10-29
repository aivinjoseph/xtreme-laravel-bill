<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";
import Highlights from "@/Components/Home/Highlights.vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import SliderItem from "@/Components/Home/SliderItem.vue";
import { ref } from "vue";

const props = defineProps({
    stats: Object
});

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
                <div class="col-span-12 text-center lg:text-left lg:col-span-10 space-y-8">
                    <h1 class="font-sans text-4xl lg:font-extrabold lg:text-6xl leading-none text-white">
                        Buy a Pre-Owned Luxury Vehicle
                    </h1>
                    <div class="font-sans font-semibold text-xl lg:text-3xl text-white max-w-2xl mx-auto md:mx-0 lg:mx-0">
                        We fulfill your desire of owning a car with financing
                        options available at a reasonable cost.
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 right-10 left-10 text-white z-30">
            <Highlights :stats="stats" />
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
                <SliderItem :index="1" image="/img/bg/4.png" />
            </swiper-slide>
            <swiper-slide>
                <SliderItem :index="2" image="/img/bg/1.jpeg" />
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
