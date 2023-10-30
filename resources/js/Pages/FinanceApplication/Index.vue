<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { router } from '@inertiajs/vue3';

    defineProps({
        applications: {
            type: Object,
            required: true,
        },
    });

    const fields = [
        {
            key: 'name',
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
            key: 'license_number',
            label: 'Driver License',
        },
    ];

    const showDetails = (application) => {
        router.get(route('finance-application.show', application.id));
    }
</script>

<template>
    <AdminLayout title="Finance Applications">
        <div class="max-w-7xl mx-auto p-8">
            <h1 class="text-2xl font-bold">Finance Applications List</h1>
            <table class="border-collapse table-auto w-full text-sm mt-4">
                <thead>
                    <tr>
                        <th v-for="field in fields" :key="field.key" class="border-b dark:border-slate-600 font-medium p-4 text-left bg-gray-100">{{ field.label }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    <tr v-for="application in applications.data" :key="application.id" class="cursor-pointer" @click="showDetails(application)">
                        <td v-for="field in fields" :key="field.key" class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ application[field.key] }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="applications.links > 3" class="mt-4">
                <Pagination :links="applications.links" />
            </div>
        </div>
    </AdminLayout>
</template>