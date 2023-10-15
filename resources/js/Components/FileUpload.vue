
<script setup>
    import { computed, ref } from 'vue';

    const props = defineProps({
        // Already uploaded images
        images: {
            type: Array,
            default: () => []
        }
    });

    const emit = defineEmits(['update:modelValue', 'onImageUpdate']);
    let files = ref([]);

    const fileUrls = computed(() => {
        return [...files.value].map(file => URL.createObjectURL(file));
    });

    const handleFileUpload = (e) => {
        files.value = [...e.target.files];
        emit('update:modelValue', files.value);
    }

    const removeFile = (index) => {
        files.value.splice(index, 1);
    }

    const removeImage = (index) => {
        props.images.splice(index, 1);
        emit('onImageUpdate', props.images);
    }
</script>

<template>
    <div class="mt-2 space-y-4">
        <div v-if="files.length || images.length" class="w-full flex gap-2">
            <div class="relative" v-for="file, index in fileUrls" :key="file.name">
                <img :src="file" class="w-36 h-36 rounded object-cover object-center">
                <button type="button" class="absolute right-2 top-2 bg-gray-200 bg-opacity-50 hover:bg-opacity-90 text-red-600 rounded-full p-1" @click="removeFile(index)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="relative" v-for="image, index in images" :key="image">
                <img :src="image" class="w-36 h-36 rounded object-cover object-center">
                <button type="button" class="absolute right-2 top-2 bg-gray-200 bg-opacity-50 hover:bg-opacity-90 text-red-600 rounded-full p-1" @click="removeImage(index)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <label class="mt-1 flex items-center px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-300 cursor-pointer">
            <input id="images" @input="handleFileUpload" accept="image/jpeg,image/jpg,image/png" type="file" class="hidden" multiple/>
            <span>Upload Images</span>
        </label>
    </div>
</template>