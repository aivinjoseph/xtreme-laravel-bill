
<script setup>
    import { computed, ref, watch } from 'vue';
    import CloseIcon from '@/Components/Icons/close.vue';
    import CheckIcon from '@/Components/Icons/check.vue';

    const props = defineProps({
        // Already uploaded images
        images: {
            type: Array,
            default: () => []
        },
        featuredImageIndex: Number
    });

    const featuredImageIndex = ref(props.featuredImageIndex);

    const emit = defineEmits(['update:modelValue', 'onImageUpdate', 'onFeaturedImageChanged']);
    let files = ref([]);

    watch(featuredImageIndex, () => {
        emit('onFeaturedImageChanged', featuredImageIndex.value);
    });

    const fileUrls = computed(() => {
        return [...files.value].map(file => URL.createObjectURL(file));
    });

    const handleFileUpload = (e) => {
        files.value = [...files.value, ...e.target.files];
        emit('update:modelValue', files.value);
    }

    const removeFile = (index) => {     
        if (index + props.images.length < featuredImageIndex.value) featuredImageIndex.value--;
   
        files.value.splice(index, 1);
    }

    const removeImage = (index) => {
        if (index < featuredImageIndex.value) featuredImageIndex.value--;

        props.images.splice(index, 1);
        emit('onImageUpdate', props.images);
    }

    const setAsFeatured = (index) => {
        featuredImageIndex.value = index;
    }
</script>

<template>
    <div class="mt-2 space-y-4">
        <div v-if="files.length || images.length" class="w-full flex flex-wrap gap-4">
            <!-- Already uploaded images -->
            <div class="relative" v-for="image, index in images" :key="image">
                <img :src="image" class="w-36 h-36 rounded object-cover object-center">
                <button v-if="index != featuredImageIndex" type="button" class="absolute right-2 top-2 bg-gray-200 bg-opacity-50 hover:bg-opacity-90 text-red-600 rounded-full p-1" @click="removeImage(index)">
                    <CloseIcon class="w-4 h-4"/>
                </button>
                <button type="button" 
                    class="absolute right-2 left-2 bottom-2 flex items-center justify-center gap-2 bg-gray-200 text-gray-900 rounded p-1" 
                    :class="{'bg-green-600 text-white': index == featuredImageIndex}"
                    @click="setAsFeatured(index)">
                    <CheckIcon v-if="featuredImageIndex == index" class="w-4 h-4"/> Featured
                </button>
            </div>

            <!-- New uploaded files -->
            <div class="relative" v-for="file, index in fileUrls" :key="file.name">
                <img :src="file" class="w-36 h-36 rounded object-cover object-center">
                <button v-if="index + images.length != featuredImageIndex" type="button" class="absolute right-2 top-2 bg-gray-200 bg-opacity-50 hover:bg-opacity-90 text-red-600 rounded-full p-1" @click="removeFile(index)">
                    <CloseIcon class="w-4 h-4"/>
                </button>
                <button type="button" 
                    class="absolute right-2 left-2 bottom-2 flex items-center justify-center gap-2 bg-gray-200 text-gray-900 rounded p-1"
                    :class="{'bg-green-600 text-white': (index + images.length) == featuredImageIndex}"
                    @click="setAsFeatured(index + images.length)">
                    <CheckIcon v-if="(index + images.length) == featuredImageIndex" class="w-4 h-4"/> Featured {{ featuredImageIndex }}
                </button>
            </div>
        </div>
        <label class="mt-1 flex items-center px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-300 cursor-pointer">
            <input id="images" @input="handleFileUpload" accept="image/jpeg,image/jpg,image/png" type="file" class="hidden" multiple/>
            <span>Upload Images</span>
        </label>
    </div>
</template>