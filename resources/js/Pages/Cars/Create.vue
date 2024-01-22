<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import FileUpload from '@/Components/FileUpload.vue';
import { computed } from 'vue';
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
    technical_condition: '',
    make: '',
    transmission: '',
    model: '',
    int_color: '',
    ext_color: '',
    body_type: '',
    description: '',
    drive: '',
    trim: '',
    fuel: '',
    door: '',
    mileage: '',
    images: [],
    files: [],
    name: '',
    year: '',
    mileage_unit: '',
    price: '',
    engine: '',
    seats: '',
    features: [],
    availability: '',
    featured_image_index: 0,
    ...props.car,
    _method: props.car.id ? 'put' : 'post'
});

const makeModels = computed(() => {
    if (!form.make) {
        return props.models;
    }

    const make = props.makes.find(make => make.name == form.make);

    if (!make) {
        return props.models;
    }

    return props.models.filter(model => model.manufacturer_id == make.id);
});

const submit = () => {
    if (props.car && props.car.id) {
        form.post(route('cars.update', props.car.id));
        return;
    }

    form.post(route('cars.store'));
};

const onImageUpdate = (images) => {
    form.images = images;
}

</script>

<template>
    <AppLayout title="Create Car">
        <div class="w-full lg:max-w-7xl mx-auto px-4 lg:px-16 py-8 mt-4">
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
                            <option v-for="model in makeModels" :key="model.id" :value="model.name">{{ model.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.model" />
                    </div>
    
                    <div>
                        <InputLabel for="name" value="Year" />
                        <TextInput id="name" v-model="form.year" type="number" class="mt-1 block w-full" required autofocus autocomplete="year" />
                        <InputError class="mt-2" :message="form.errors.year" />
                    </div>
                
                    <div>
                        <InputLabel for="body_type" value="Body Type" />
                        <select v-model="form.body_type" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Body Type</option>
                            <option v-for="bodyType in bodyTypes" :key="bodyType.id" :value="bodyType.name">{{ bodyType.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.body_type" />
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
                        <InputLabel for="door" value="Door" />
                        <select v-model="form.door" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Door</option>
                            <option v-for="door in doors" :key="door.id" :value="door.name">{{ door.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.door" />
                    </div>

                    <div>
                        <InputLabel for="fuel" value="Fuel" />
                        <select v-model="form.fuel" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Fuel</option>
                            <option v-for="fuel in fuels" :key="fuel.id" :value="fuel.name">{{ fuel.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.fuel" />
                    </div>

                    <div>
                        <InputLabel for="technical_condition" value="Technical Condition" />
                        <select v-model="form.technical_condition" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Technical Condition</option>
                            <option v-for="condition in conditions" :key="condition.id" :value="condition.name">{{ condition.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.technical_condition" />
                    </div>

                    <div>
                        <InputLabel for="drive" value="Drive" />
                        <select v-model="form.drive" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Drive</option>
                            <option v-for="drive in drives" :key="drive.id" :value="drive.name">{{ drive.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.drive" />
                    </div>

                    <div>
                        <InputLabel for="ext_color" value="Ext Color" />
                        <select v-model="form.ext_color" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Color</option>
                            <option v-for="color in colors" :key="color.id" :value="color.name">{{ color.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.ext_color" />
                    </div>

                    <div>
                        <InputLabel for="int_color" value="Int Color" />
                        <select v-model="form.int_color" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Color</option>
                            <option v-for="color in colors" :key="color.id" :value="color.name">{{ color.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.int_color" />
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
                            <InputLabel for="mileage_unit" value="Unit" />
                            <select v-model="form.mileage_unit" class="rounded border-gray-300 w-full mt-1">
                                <option value="">Select Unit</option>
                                <option value="mi">Miles</option>
                                <option value="km">Km</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.mileage_unit" />
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
                            <TextInput id="name" v-model="form.engine" type="text" class="mt-1 block w-full" required autofocus autocomplete="engine" />
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
                        <InputLabel for="trim" value="Trim" />
                        <select v-model="form.trim" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Trim</option>
                            <option v-for="trim in trims" :key="trim.id" :value="trim.name">{{ trim.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.trim" />
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

                </div>

                <div class="mt-4">
                    <InputLabel for="video_link" value="Video Link" />
                    <TextInput id="video_link" v-model="form.video_link" type="text" class="mt-1 block w-full" autofocus autocomplete="video_link" />
                    <InputError class="mt-2" :message="form.errors.video_link" />
                </div>

                <div class="mt-4">
                    <InputLabel for="images" value="Images" />
                    <FileUpload v-model="form.files" :images="form.images" :featuredImageIndex="form.featured_image_index" @on-image-update="onImageUpdate" @on-featured-image-changed="(i) => form.featured_image_index = i"/>
                    <InputError class="mt-2" :message="form.errors.files" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ car && car.id ? 'Update' : 'Create' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>