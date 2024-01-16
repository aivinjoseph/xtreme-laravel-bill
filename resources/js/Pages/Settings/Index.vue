<script setup>
    import { Head, Link, router, useForm } from '@inertiajs/vue3';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import FileUpload from '@/Components/FileUpload.vue';
    import InputError from '@/Components/InputError.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        settings: Array,
    });

    const homeImages = props.settings.filter((setting) => setting.key === 'home_images')[0];

    const form = useForm({
        images: homeImages ? JSON.parse(homeImages.value) : [],
        files: [],
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
        </section>
    </AdminLayout>
</template>



<style scoped>
/* Your component styles here */
</style>
