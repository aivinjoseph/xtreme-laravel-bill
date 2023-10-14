<script setup>
import { onMounted, ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

defineProps({
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);
const updateContent = (content) => {
    emit('update:modelValue', content);
};

</script>

<template>
    <QuillEditor class="h-48" theme="snow" content-type="html" :content="modelValue" @update:content="updateContent"/>
    <!-- <textarea
        ref="input"
        :rows="rows"
        class="border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea> -->
</template>
