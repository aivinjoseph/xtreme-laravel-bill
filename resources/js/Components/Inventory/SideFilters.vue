<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Slider from '@vueform/slider'

    defineProps({
        form: {
            type: Object,
            required: true,
        },
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

    const currentYear = new Date().getFullYear();
    const merge = 300*1000;
    const yearMerge = 100;
    const format = {
        prefix: '$',
        decimals: 2
    }
</script>

<template>
    <div class="p-4 bg-gray-100 rounded shadow-sm flex flex-col gap-4">
        <div class="mt-2 space-y-2">
            <InputLabel for="name" value="Year" />
            <Slider class="slider-red" v-model="form.year" :merge="yearMerge" :min="1970" :step="1" :max="currentYear"/>
        </div>
        <div class="mt-4 space-y-2">
            <InputLabel for="name" value="Mileage" />
            <Slider v-model="form.mileage" :merge="merge" :min="0" :step="100" :max="300000"/>
        </div>

        <div class="mt-4 space-y-2">
            <InputLabel for="name" value="Price" />
            <Slider v-model="form.price" :min="0" :step="100" :max="300000" :merge="merge" :format="format"/>
        </div>

        <div>
            <InputLabel for="body_type" value="Body Type" />
            <select v-model="form.body_type" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Body Type</option>
                <option v-for="bodyType in bodyTypes" :key="bodyType.id" :value="bodyType.name">{{ bodyType.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="transmission" value="Transmission" />
            <select v-model="form.transmission" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Transmission</option>
                <option v-for="transmission in transmissions" :key="transmission.id" :value="transmission.name">{{ transmission.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="door" value="Door" />
            <select v-model="form.door" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Door</option>
                <option v-for="door in doors" :key="door.id" :value="door.name">{{ door.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="fuel" value="Fuel" />
            <select v-model="form.fuel" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Fuel</option>
                <option v-for="fuel in fuels" :key="fuel.id" :value="fuel.name">{{ fuel.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="technical_condition" value="Technical Condition" />
            <select v-model="form.technical_condition" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Technical Condition</option>
                <option v-for="condition in conditions" :key="condition.id" :value="condition.name">{{ condition.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="drive" value="Drive" />
            <select v-model="form.drive" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Drive</option>
                <option v-for="drive in drives" :key="drive.id" :value="drive.name">{{ drive.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="ext_color" value="Ext Color" />
            <select v-model="form.ext_color" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Color</option>
                <option v-for="color in colors" :key="color.id" :value="color.name">{{ color.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="int_color" value="Int Color" />
            <select v-model="form.int_color" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Color</option>
                <option v-for="color in colors" :key="color.id" :value="color.name">{{ color.name }}</option>
            </select>
        </div>

        <div>
            <InputLabel for="availability" value="Availability" />
            <select v-model="form.availability" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Availability</option>
                <option value="available">Available</option>
                <option value="sold">Sold</option>
                <option value="upcoming">Upcoming</option>
            </select>
        </div>

        <div class="flex gap-4">
            <div class="w-full">
                <InputLabel for="name" value="Seats" />
                <TextInput id="name" v-model="form.seats" type="number" class="mt-1 block w-full" required autofocus autocomplete="seats" />
            </div>
        </div>

        <div>
            <InputLabel for="trim" value="Trim" />
            <select v-model="form.trim" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Trim</option>
                <option v-for="trim in trims" :key="trim.id" :value="trim.name">{{ trim.name }}</option>
            </select>
        </div>

        <div class="lg:col-span-3">
            <InputLabel for="features" value="Features" />
            <div class="flex gap-2 flex-wrap">
                <div v-for="feature of features" :key="feature.id" class="flex gap-1 items-center">
                    <input type="checkbox" :value="feature.name" id="features" v-model="form.features" />
                    <span class="text-sm">{{ feature.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style src="@vueform/slider/themes/default.css" lang="scss">
    :root {
    --slider-connect-bg: #3B82F6;
    --slider-tooltip-bg: #3B82F6;
    --slider-handle-ring-color: #3B82F630;
    }
    // .slider-red {
    //     --slider-connect-bg: #EF4444;
    //     --slider-tooltip-bg: #EF4444;
    //     --slider-handle-ring-color: #EF444430;
    // }
</style>