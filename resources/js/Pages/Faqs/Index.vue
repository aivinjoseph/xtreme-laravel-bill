<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    faqs: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <AppLayout title="Faqs">
        <div class="max-w-7xl mx-auto p-8">
            <div class="space-y-4">
                <h1 class="text-3xl font-bold">Frequently Asked Questions</h1>
                <p class="text-gray-500 text-sm mt-1">We have compiled a list of frequently asked questions for your convenience. If you have any other questions, please feel free to contact us.</p>
                <div class="space-y-1">
                    <template v-for="(faq, index) in faqs" :key="index">
                        <div class="border border-gray-200 rounded-lg p-4 cursor-pointer" @click="faq.open = !faq.open">
                            <div class="flex justify-between">
                                <h2 class="text-lg font-bold">{{ faq.question }}</h2>
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg :class="{ 'rotate-180': faq.open }" class="w-5 h-5 transition-transform duration-200 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-2 text-gray-500 transition-all ease-in-out duration-300 overflow-y-auto" :style="{maxHeight: faq.open ? '500px': 0}">{{ faq.answer }}</div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
