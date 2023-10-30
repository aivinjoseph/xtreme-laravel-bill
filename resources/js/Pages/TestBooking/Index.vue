<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import Pagination from '@/Components/Pagination.vue';

    defineProps({
        bookings: {
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
            key: 'date',
            label: 'Date',
        },
        {
            key: 'message',
            label: 'Message',
        },
    ];
</script>

<template>
    <AdminLayout title="Bookings">
        <div class="max-w-7xl mx-auto p-8">
            <h1 class="text-2xl font-bold">Test Bookings List</h1>
            <table class="border-collapse table-auto w-full text-sm mt-4">
                <thead>
                    <tr>
                        <th v-for="field in fields" :key="field.key" class="bg-gray-100 border-b dark:border-slate-600 font-medium p-4 text-left">{{ field.label }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    <tr v-for="booking in bookings.data" :key="booking.id">
                        <td v-for="field in fields" :key="field.key" class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ booking[field.key] }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="bookings.links > 3" class="mt-4">
                <Pagination :links="bookings.links" />
            </div>
        </div>
    </AdminLayout>
</template>