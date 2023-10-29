<script setup>
    import { applicantInfo, applicantAddress, applicantEmployer } from './finance-form';
    import AppLayout from '@/Layouts/AppLayout.vue';

    const props = defineProps({
        application: Object
    })

   const sections = [
        {
            title: 'Applicant Info',
            fields: Object.keys(applicantInfo)
        },
        {
            title: 'Applicant Address',
            fields: Object.keys(applicantAddress)
        },
        {
            title: 'Applicant Employer',
            fields: Object.keys(applicantEmployer)
        }
   ]
</script>

<template>
    <AppLayout title="Finance Application Detail">
        <div class="max-w-7xl mx-auto p-8 space-y-8">
            <div class="py-4 bg-gray-100 rounded p-4" v-for="section in sections" :key="section.title">
                <h2 class="text-xl font-bold font-gray-800">{{ section.title }}</h2>
                <div class="mt-4 grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <div v-for="field in section.fields" :key="field">
                        <div class="capitalize font-semibold text-gray-800">{{ field.split('_').join(' ') }}</div>
                        <div class="text-gray-500">{{ application[field] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>