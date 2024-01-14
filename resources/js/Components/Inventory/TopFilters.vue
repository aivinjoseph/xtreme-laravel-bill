<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import ResetIcon from '@/Components/Icons/reset.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';

    defineProps({
        form: Object,
        makes: Array,
        models: Array,
    });

    const emit = defineEmits(['submit', 'reset']);
    const submit = () => emit('submit');
</script>

<template>
    <div class="w-full grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-100 p-4 rounded">
        <div>
            <InputLabel for="make" value="Make" />
            <select v-model="form.make" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Make</option>
                <option v-for="make in makes" :key="make.id" :value="make.name">{{ make.name }}</option>
            </select>
        </div>
        <div>
            <InputLabel for="model" value="Model" />
            <select v-model="form.model" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Model</option>
                <option v-for="model in models" :key="model.id" :value="model.name">{{ model.name }}</option>
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
        <div class="flex items-end justify-end gap-2">
            <SecondaryButton @click="$emit('reset')"><ResetIcon class="h-4 w-6"/> Reset Filters</SecondaryButton>
        </div>
    </div>
</template>