<script setup>
import { computed, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import CloseIcon from '@/Components/Icons/close.vue';
import PrevIcon from '@/Components/Icons/prev.vue';
import NextIcon from '@/Components/Icons/next.vue';

const props = defineProps({
    images: {
        type: Array,
        required: true
    }
})

const hasNext = computed(() => {
    return imageIndex.value < props.images.length - 1;
})

const hasPrev = computed(() => {
    return imageIndex.value > 0;
})

const showModal = ref(false);
const imageIndex = ref(0);
const openModal = (index) => {
    imageIndex.value = index;
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
}

const next = () => {
    if (imageIndex.value < props.images.length - 1) {
        imageIndex.value++;
    }
}

const prev = () => {
    if (imageIndex.value > 0) {
        imageIndex.value--;
    }
}

</script>
<template>
    <Modal max-width="6xl" :show="showModal" @close="closeModal">
        <div class="container relative">
            <div class="flex justify-end absolute top-4 right-6">
                <button @click="closeModal" class="font-bold text-lg z-10 bg-red-800 rounded text-white p-2">
                    <CloseIcon class="w-10 h-10 text-white"/>
                </button>
            </div>
            <div class="absolute right-6 top-0 h-full flex items-center">
                <button v-if="hasNext" class="bg-orange-500 text-white p-2 rounded text-2xl font-bold" @click="next">
                    <NextIcon class="w-10 h-10"/>
                </button>
            </div>
            <img class="rounded w-full h-[calc(100vh-50px)]" :src="images[imageIndex]" alt="image">
            <div class="absolute top-0 left-6 h-full flex items-center">
                <button v-if="hasPrev" class="bg-orange-500 text-white rounded text-2xl font-bold p-2" @click="prev">
                    <PrevIcon class="w-10 h-10" />
                </button>
            </div>
        </div>
    </Modal>
    <div>
        <div class="container grid grid-cols-1 md:grid-cols-3 gap-2 mx-auto py-4">
            <div v-for="(image, index) in images" :key="image" class="md:first:col-span-3" @click="openModal(index)">
                <img class="rounded cursor-pointer h-full object-cover object-center" :src="image" alt="image">
            </div>
        </div>
    </div>
</template>