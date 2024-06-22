<script setup>
    import { info } from '@/info';
    import QRCodeVue3 from "qrcode-vue3";

    const carLink = window.location.href;

    const props = defineProps({
        data: Array,
        car: Object
    })
</script>

<template>
    <div class="p-4">
        <div class="text-4xl font-black">
            {{ info.name }}
        </div>
        <div class="mt-8 flex justify-between">
            <div class="text-2xl font-bold">{{ car.name }}</div>
            <div class="text-2xl font-bold">${{ car.price }}</div>
        </div>
        <div>
            VIN #: <span>{{ car.vin }}</span>
        </div>
        <!-- <div class="mt-4">
            <img loading="lazy" class="object-cover object-center rounded-t h-40" :src="car.images[car.featured_image_index]" alt="Vehicle image" />
        </div> -->
        <div class="mt-4 bg-gray-100 rounded-lg">
            <div class="grid grid-cols-2 gap-4">
                <div v-for="item in data" :key="item.name">
                    <div class="font-bold text-gray-700">{{ item.name }}</div>
                    <div class="text-gray-500">{{ item.value }}</div>
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <div>
                <div class="mt-8">
                    Contact Number: {{ info.phone }}
                </div>
                <div>
                    Email: {{ info.email }}
                </div>
            </div>
            <div>
                
                <QRCodeVue3
                    :width="200"
                    :height="200"
                    :value="carLink"
                    :qrOptions="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
                    :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }"
                    :dotsOptions="{
                    type: 'dots',
                    color: '#26249a',
                    gradient: {
                        type: 'linear',
                        rotation: 0,
                        colorStops: [
                        { offset: 0, color: '#000000' },
                        { offset: 1, color: '#000000' },
                        ],
                    },
                    }"
                    :backgroundOptions="{ color: '#ffffff' }"
                    :cornersSquareOptions="{ type: 'dot', color: '#000000' }"
                    :cornersDotOptions="{ type: undefined, color: '#000000' }"
                    fileExt="png"
                    myclass="my-qur"
                    imgclass="img-qr"
                />
            </div>
        </div>
    </div>
</template>