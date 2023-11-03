<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import FileUpload from '@/Components/FileUpload.vue';
const props = defineProps({
    models: Array,
    makes: Array,
    colors: Array,
    trims: Array,
    drives: Array,
    fuels: Array,
    bodyTypes: Array,
    doors: Array,
    conditions: Array,
    transmissions: Array,
    features: Array,
    car: {
        type: Object,
        default: {}
    }
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    make: '',
    model: '',
    description: '',
    trim: '',
    mileage: '',
    year: '',
    engine: '',
    seats: '',
    transmission: ''
});

const submit = () => {
    form.post(route('appraisals.store'));
};

const onImageUpdate = (images) => {
    form.images = images;
}

</script>

<template>
    <AppLayout title="Create Car">
        <div class="w-full lg:max-w-7xl mx-auto px-4 lg:px-16 py-8 mt-4">
            <form @submit.prevent="submit" class="lg:w-1/2 mx-auto">
                <h1 class="text-xl font-bold">Trade-In Estimate</h1>
                <div class="mt-2 text-gray-500">
                    Find out how much your trade-in vehicle is worth. Our trade-in estimate tool uses data from industry leading partners, giving you relevant and robust vehicle valuations.
                </div>
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="first_name" value="First Name" />
                        <TextInput id="first_name" v-model="form.first_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="first_name" />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.last_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="last_name" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>
                    <div>
                        <InputLabel for="name" value="Email" />
                        <TextInput id="name" v-model="form.email" type="text" class="mt-1 block w-full" required autofocus autocomplete="email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="name" value="Phone" />
                        <TextInput id="name" v-model="form.phone" type="text" class="mt-1 block w-full" required autofocus autocomplete="phone" />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-300 grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="make" value="Make" />
                        <select v-model="form.make" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Make</option>
                            <option v-for="make in makes" :key="make.id" :value="make.name">{{ make.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.make" />
                    </div>
    
                    <div>
                        <InputLabel for="model" value="Model" />
                        <select v-model="form.model" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Model</option>
                            <option v-for="model in models" :key="model.id" :value="model.name">{{ model.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.model" />
                    </div>
    
                    <div>
                        <InputLabel for="name" value="Year" />
                        <TextInput id="name" v-model="form.year" type="number" class="mt-1 block w-full" required autofocus autocomplete="year" />
                        <InputError class="mt-2" :message="form.errors.year" />
                    </div>          

                    <div>
                        <InputLabel for="transmission" value="Transmission" />
                        <select v-model="form.transmission" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Transmission</option>
                            <option v-for="transmission in transmissions" :key="transmission.id" :value="transmission.name">{{ transmission.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.transmission" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Mileage" />
                        <TextInput id="name" v-model="form.mileage" type="number" class="mt-1 block w-full" required autofocus autocomplete="mileage" />
                        <InputError class="mt-2" :message="form.errors.mileage" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Engine" />
                        <TextInput id="name" v-model="form.engine" type="text" class="mt-1 block w-full" required autofocus autocomplete="engine" />
                        <InputError class="mt-2" :message="form.errors.engine" />
                    </div>

                    <div>
                        <InputLabel for="trim" value="Trim" />
                        <select v-model="form.trim" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Trim</option>
                            <option v-for="trim in trims" :key="trim.id" :value="trim.name">{{ trim.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.trim" />
                    </div>
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Message" />
                    <TextArea id="description" v-model="form.description" type="text" class="mt-1 block w-full" required autofocus autocomplete="description" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>