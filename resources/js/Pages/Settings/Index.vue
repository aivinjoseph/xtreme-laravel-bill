<script setup>
    import { Head, Link, router, useForm } from '@inertiajs/vue3';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import FileUpload from '@/Components/FileUpload.vue';
    import InputError from '@/Components/InputError.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        settings: Array,
        dealerSettings: Object,
        publicWebsiteUrl: String,
    });

    const homeImages = props.settings.filter((setting) => setting.key === 'home_images')[0];
    const publicWebsiteSetting = props.settings.find((setting) => setting.key === 'public_website_url');

    const form = useForm({
        images: homeImages ? JSON.parse(homeImages.value) : [],
        files: [],
        public_website_url: publicWebsiteSetting?.value || props.publicWebsiteUrl || '',
        dealer: {
            name: props.dealerSettings?.name || '',
            address: props.dealerSettings?.address || '',
            phone: props.dealerSettings?.phone || '',
            email: props.dealerSettings?.email || '',
            registration_number: props.dealerSettings?.registration_number || '',
            hst_registration_number: props.dealerSettings?.hst_registration_number || '',
            hst_rate: props.dealerSettings?.hst_rate ?? 0.13,
        },
    });


    const submit = () => {
        form.post(route('settings.store'))
    }
</script>

<template>
    <AdminLayout title="Settings">
        <section class="p-8">
            <div class="mt-4">
                <InputLabel for="images" value="Home page images" />
                <FileUpload v-model="form.files" :images="form.images" :featuredImageIndex="0" :multiple="true" />
                <InputError class="mt-2" :message="form.errors.files" />
            </div>
            <div>
                <primary-button @click="submit" class="mt-4">Save</primary-button>
            </div>

            <div class="mt-10 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-800">Public vehicle website</h2>
                <p class="mt-1 text-sm text-gray-500">This base URL is used by Window Sticker QR codes, including while the admin is running locally.</p>
                <div class="mt-4 max-w-2xl">
                    <InputLabel for="public-website-url" value="Public website URL" />
                    <input id="public-website-url" v-model="form.public_website_url" type="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://www.example.com" />
                    <InputError class="mt-2" :message="form.errors.public_website_url" />
                </div>
            </div>

            <div class="mt-10 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-800">Retail Bill of Sale</h2>
                <p class="mt-1 text-sm text-gray-500">These values are copied onto new Bill of Sale documents. Environment values provide the initial defaults.</p>
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div v-for="field in [
                        ['name', 'Dealer name'],
                        ['address', 'Dealer address'],
                        ['phone', 'Dealer phone'],
                        ['email', 'Dealer email'],
                        ['registration_number', 'Dealer registration number'],
                        ['hst_registration_number', 'HST registration number'],
                    ]" :key="field[0]">
                        <InputLabel :for="`dealer-${field[0]}`" :value="field[1]" />
                        <input :id="`dealer-${field[0]}`" v-model="form.dealer[field[0]]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <InputLabel for="dealer-hst-rate" value="HST rate" />
                        <input id="dealer-hst-rate" v-model="form.dealer.hst_rate" type="number" step="0.0001" min="0" max="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>



<style scoped>
/* Your component styles here */
</style>
