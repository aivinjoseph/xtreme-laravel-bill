<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import Pagination from '@/Components/Pagination.vue';

    defineProps({
        contacts: {
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
            key: 'subject',
            label: 'Subject',
        },
        {
            key: 'message',
            label: 'Message',
        },
    ];
</script>

<template>
    <AdminLayout title="Contacts">
        <div class="max-w-7xl mx-auto p-8">
            <h1 class="text-2xl font-bold">Contacts List</h1>
            <table class="border-collapse table-auto w-full text-sm mt-4">
                <thead>
                    <tr>
                        <th v-for="field in fields" :key="field.key" class="border-b font-medium p-4 text-left">{{ field.label }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="contact in contacts.data" :key="contact.id">
                        <td v-for="field in fields" :key="field.key" class="border-b border-slate-100 p-4 pl-8">{{ contact[field.key] }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="contacts.links > 3" class="mt-4">
                <Pagination :links="contacts.links" />
            </div>
        </div>
    </AdminLayout>
</template>