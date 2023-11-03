<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import Pagination from '@/Components/Pagination.vue';

    defineProps({
        appraisals: {
            type: Object,
            required: true,
        },
    });

    const fields = [
        {
            key: 'first_name',
            label: 'Name',
        },
        {
            key: 'email',
            label: 'Email',
        },
        {
            key: 'phone',
            label: 'Phone',
        },
        {
            key: 'make',
            label: 'Make',
        },
        {
            key: 'model',
            label: 'Model',
        },
        {
            key: 'trim',
            label: 'Trim',
        },
        {
            key: 'engine',
            label: 'Engine',
        },
        {
            key: 'transmission',
            label: 'Transmission',
        },
        {
            key: 'year',
            label: 'Year',
        },
        {
            key: 'mileage',
            label: 'Mileage',
        },
        {
            key: 'description',
            label: 'Description',
        },
    ];
</script>

<template>
    <AdminLayout title="Appraisals">
        <div class="max-w-7xl mx-auto p-8 overflow-x-scroll">
            <h1 class="text-2xl font-bold">Appraisals List</h1>
            <table class="border-collapse table-auto w-full text-sm mt-4">
                <thead>
                    <tr>
                        <th v-for="field in fields" :key="field.key" class="border-b dark:border-slate-600 font-medium p-4 text-left">{{ field.label }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    <tr v-for="appraisal in appraisals.data" :key="appraisal.id">
                        <td v-for="field in fields" :key="field.key" class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ appraisal[field.key] }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="appraisals.links > 3" class="mt-4">
                <Pagination :links="appraisals.links" />
            </div>
        </div>
    </AdminLayout>
</template>