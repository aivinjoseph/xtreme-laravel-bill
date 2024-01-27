<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    faqs: {
        type: Array,
        required: true,
    },
});

const deleteFaq = (faq) => {
    if (confirm('Are you sure you want to delete this faq?')) {
        router.delete(route('faqs.destroy', faq.id));
    }
};

</script>

<template>
    <AdminLayout title="Faqs">
        <div class="max-w-7xl mx-auto p-8">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <h1 class="text-3xl font-bold">Frequently Asked Questions</h1>
                    <PrimaryButton>
                        <Link class="text-white" :href="route('faqs.create')">Create</Link>
                    </PrimaryButton>
                </div>
                <div class="space-y-1">
                    <template v-for="(faq, index) in faqs" :key="index">
                        <div class="border border-gray-200 rounded-lg p-4 cursor-pointer" @click="faq.open = !faq.open">
                            <div class="flex justify-between">
                                <h2 class="text-lg font-bold">{{ faq.question }}</h2>
                                <div class="flex gap-4 items-center">
                                    <Link class="text-indigo-500" :href="route('faqs.edit', faq.id)">Edit</Link>
                                    <button @click="deleteFaq(faq)" class="text-red-500 hover:text-gray-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 text-gray-500 transition-all ease-in-out duration-300 overflow-y-auto" :style="{maxHeight: faq.open ? '500px': 0}">{{ faq.answer }}</div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
