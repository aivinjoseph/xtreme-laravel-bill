<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

defineProps({
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
    features: Array
});

const form = useForm({
    technical_condition_id: '',
    manufacturer_id: '',
    transmission_id: '',
    car_model_id: '',
    int_color_id: '',
    ext_color_id: '',
    body_type_id: '',
    description: '',
    drive_id: '',
    trim_id: '',
    fuel_id: '',
    door_id: '',
    mileage: '',
    images: [],
    name: '',
    year: '',
    unit: '',
    price: '',
    engine: '',
    seats: '',
    features: [],
    availability: '',
});

const submit = () => {
    form.post(route('cars.store'), {
        onFinish: () => form.reset('name', 'images'),
    });
};
</script>

<template>
    <AppLayout title="Create Car">
        <div class="w-full lg:max-w-7xl mx-auto px-4 lg:px-16 py-8 mt-16">
            <form @submit.prevent="submit" class="lg:w-1/2 mx-auto">
                <div>
                    <InputLabel for="name" value="Title" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Description" />
                    <RichTextEditor id="description" v-model="form.description" type="text" class="mt-1 block w-full" required autofocus autocomplete="description" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <InputLabel for="manufacturer_id" value="Make" />
                        <select v-model="form.manufacturer_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Make</option>
                            <option v-for="make in makes" :key="make.id" :value="make.id">{{ make.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.manufacturer_id" />
                    </div>
    
                    <div>
                        <InputLabel for="car_model_id" value="Model" />
                        <select v-model="form.car_model_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Model</option>
                            <option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.car_model_id" />
                    </div>
    
                    <div>
                        <InputLabel for="name" value="Year" />
                        <TextInput id="name" v-model="form.year" type="number" class="mt-1 block w-full" required autofocus autocomplete="year" />
                        <InputError class="mt-2" :message="form.errors.year" />
                    </div>
                

                    <div>
                        <InputLabel for="body_type_id" value="Body Type" />
                        <select v-model="form.body_type_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Body Type</option>
                            <option v-for="bodyType in bodyTypes" :key="bodyType.id" :value="bodyType.id">{{ bodyType.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.body_type_id" />
                    </div>

                    <div>
                        <InputLabel for="transmission_id" value="Transmission" />
                        <select v-model="form.transmission_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Transmission</option>
                            <option v-for="transmission in transmissions" :key="transmission.id" :value="transmission.id">{{ transmission.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.transmission_id" />
                    </div>

                    <div>
                        <InputLabel for="door_id" value="Door" />
                        <select v-model="form.door_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Door</option>
                            <option v-for="door in doors" :key="door.id" :value="door.id">{{ door.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.door_id" />
                    </div>

                    <div>
                        <InputLabel for="fuel_id" value="Fuel" />
                        <select v-model="form.fuel_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Fuel</option>
                            <option v-for="fuel in fuels" :key="fuel.id" :value="fuel.id">{{ fuel.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.fuel_id" />
                    </div>

                    <div>
                        <InputLabel for="technical_condition_id" value="Technical Condition" />
                        <select v-model="form.technical_condition_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Technical Condition</option>
                            <option v-for="condition in conditions" :key="condition.id" :value="condition.id">{{ condition.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.technical_condition_id" />
                    </div>

                    <div>
                        <InputLabel for="drive_id" value="Drive" />
                        <select v-model="form.drive_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Drive</option>
                            <option v-for="drive in drives" :key="drive.id" :value="drive.id">{{ drive.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.drive_id" />
                    </div>

                    <div>
                        <InputLabel for="ext_color_id" value="Ext Color" />
                        <select v-model="form.ext_color_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Color</option>
                            <option v-for="color in colors" :key="color.id" :value="color.id">{{ color.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.ext_color_id" />
                    </div>

                    <div>
                        <InputLabel for="int_color_id" value="Int Color" />
                        <select v-model="form.int_color_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Color</option>
                            <option v-for="color in colors" :key="color.id" :value="color.id">{{ color.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.int_color_id" />
                    </div>

                    <div>
                        <InputLabel for="availability" value="Availability" />
                        <select v-model="form.availability" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Availability</option>
                            <option value="available">Available</option>
                            <option value="sold">Sold</option>
                            <option value="upcoming">Upcoming</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.availability" />
                    </div>

                    <div class="flex gap-4">
                        <div class="w-full">
                            <InputLabel for="name" value="Mileage" />
                            <TextInput id="name" v-model="form.mileage" type="number" class="mt-1 block w-full" required autofocus autocomplete="mileage" />
                            <InputError class="mt-2" :message="form.errors.mileage" />
                        </div>
                        <div>
                            <InputLabel for="unit" value="Unit" />
                            <select v-model="form.unit" class="rounded border-gray-300 w-full mt-1">
                                <option value="">Select Unit</option>
                                <option value="miles">Miles</option>
                                <option value="km">Km</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.availability" />
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-full">
                            <InputLabel for="name" value="Price" />
                            <TextInput id="name" v-model="form.price" type="number" class="mt-1 block w-full" required autofocus autocomplete="price" />
                            <InputError class="mt-2" :message="form.errors.price" />
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-full">
                            <InputLabel for="name" value="Engine" />
                            <TextInput id="name" v-model="form.engine" type="number" class="mt-1 block w-full" required autofocus autocomplete="engine" />
                            <InputError class="mt-2" :message="form.errors.engine" />
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-full">
                            <InputLabel for="name" value="Seats" />
                            <TextInput id="name" v-model="form.seats" type="number" class="mt-1 block w-full" required autofocus autocomplete="seats" />
                            <InputError class="mt-2" :message="form.errors.seats" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="trim_id" value="Trim" />
                        <select v-model="form.trim_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Trim</option>
                            <option v-for="trim in trims" :key="trim.id" :value="trim.id">{{ trim.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.trim_id" />
                    </div>

                    <div class="lg:col-span-3">
                        <InputLabel for="features" value="Features" />
                        <div class="flex gap-2 flex-wrap">
                            <div v-for="feature of features" :key="feature.id" class="flex gap-1 items-center">
                                <input type="checkbox" :value="feature.name" id="features" v-model="form.features" /> 
                                <span class="text-sm">{{ feature.name }}</span>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.features" />
                    </div>

                    <div>
                        <InputLabel for="images" value="Images" />
                        <label class="mt-1 flex items-center px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-300 cursor-pointer">
                            <input id="images" @input="form.images = $event.target.files" accept="image/jpeg,image/jpg,image/png" type="file" class="hidden" multiple required/>
                            <span>Upload Images</span>
                        </label>
                        <InputError class="mt-2" :message="form.errors.images" />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>